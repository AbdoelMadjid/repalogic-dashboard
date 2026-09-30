<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DukunganAplikasi\ProfilAplikasi;
use App\Models\Admin\DukunganAplikasi\WebsiteSection;
use App\Models\Admin\ManajemenPengguna\UserLogin;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\ProfileLike;
use App\Models\User;
use App\Models\UserMediaHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the dynamic data-driven and role-based dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->hasAnyRole(['superadmin', 'admin']);

        // Data Profile & Sapaan Waktu
        $greeting = $this->getTimeGreeting();
        $lastLoginRecord = UserLogin::where('user_id', $user->id)
            ->latest('login_at')
            ->first();

        if ($isAdmin) {
            return $this->renderAdminDashboard($user, $greeting, $lastLoginRecord);
        } else {
            return $this->renderUserDashboard($user, $greeting, $lastLoginRecord);
        }
    }

    /**
     * Render rich admin metrics dashboard.
     */
    protected function renderAdminDashboard($user, string $greeting, $lastLoginRecord)
    {
        // 1. User Stats
        $userStats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'pending' => User::where('status', 'pending')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'rejected' => User::where('status', 'rejected')->count(),
            'pending_deactivations' => User::whereNotNull('deactivation_requested_at')->count(),
        ];

        // 2. Role & Permission Stats
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $rolesDistribution = Role::withCount('users')->get();

        // 3. Login Stats & Online Presence
        $todayLogins = UserLogin::whereDate('login_at', today())->count();
        $onlineUserIds = Cache::get('online-users-list', []);
        $activeOnlineCount = 0;
        foreach ($onlineUserIds as $uId) {
            if (Cache::has('user-online-' . $uId)) {
                $activeOnlineCount++;
            }
        }
        if ($activeOnlineCount === 0 && auth()->check()) {
            $activeOnlineCount = 1;
        }

        // 4. 7-Day Chart Data (Logins & New Registrations)
        $chartDates = [];
        $chartLogins = [];
        $chartRegistrations = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateLabel = $date->translatedFormat('d M');
            $dateStr = $date->toDateString();

            $chartDates[] = $dateLabel;
            $chartLogins[] = UserLogin::whereDate('login_at', $dateStr)->count();
            $chartRegistrations[] = User::whereDate('created_at', $dateStr)->count();
        }

        // 5. System Health & Database Backup Stats
        $backupPath = storage_path('app/backups');
        $backupFiles = [];
        $totalBackupSize = 0;
        $lastBackupTime = null;
        $lastBackupName = null;

        if (File::exists($backupPath)) {
            $files = File::files($backupPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'sql') {
                    $totalBackupSize += $file->getSize();
                    $mTime = $file->getMTime();
                    if ($lastBackupTime === null || $mTime > $lastBackupTime) {
                        $lastBackupTime = $mTime;
                        $lastBackupName = $file->getFilename();
                    }
                    $backupFiles[] = $file;
                }
            }
        }

        $appProfil = ProfilAplikasi::first();
        $isMaintenance = $appProfil->is_maintenance ?? false;
        $activeSectionsCount = WebsiteSection::where('is_active', true)->count();

        // 6. Pending Actions
        $pendingApprovals = User::where('status', 'pending')
            ->latest('created_at')
            ->take(5)
            ->get();

        $pendingDeactivations = User::whereNotNull('deactivation_requested_at')
            ->latest('deactivation_requested_at')
            ->take(5)
            ->get();

        // 7. Recent Logins (Global)
        $recentLogins = UserLogin::with(['user.roles'])
            ->latest('login_at')
            ->take(6)
            ->get();

        // 8. Recent Unique Conversations
        $recentMessages = $this->getRecentConversations($user);

        // 9. Active Contacts & Team Directory (Full Widget) with Friendship & Like Indicators
        $contactUsers = $this->prepareContactsForDashboard($user);

        // 10. Friendship & Likes Stats for Current User
        $incomingFriendRequestsCount = Friendship::where('receiver_id', $user->id)->pending()->count();
        $outgoingFriendRequestsCount = Friendship::where('sender_id', $user->id)->pending()->count();
        $totalFriendsCount = $user->friends_count;
        $totalProfileLikesCount = $user->profile_likes_count;

        // 11. Activity Histories for Directory Tabs (Scoped to Current Authenticated User)
        $friendshipHistories = Friendship::with(['sender.detail', 'receiver.detail', 'sender.roles', 'receiver.roles'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
            })
            ->latest('updated_at')
            ->take(50)
            ->get();

        $profileLikeHistories = ProfileLike::with(['user.detail', 'targetUser.detail', 'user.roles', 'targetUser.roles'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('target_user_id', $user->id);
            })
            ->latest('created_at')
            ->take(50)
            ->get();

        $chatHistories = Message::with(['sender.detail', 'receiver.detail', 'sender.roles', 'receiver.roles'])
            ->where(function ($q) use ($user) {
                $q->where(function ($sq) use ($user) {
                    $sq->where('sender_id', $user->id)->where('deleted_for_sender', false);
                })->orWhere(function ($sq) use ($user) {
                    $sq->where('receiver_id', $user->id)->where('deleted_for_receiver', false);
                });
            })
            ->latest('created_at')
            ->take(50)
            ->get();

        $mediaHistories = UserMediaHistory::with(['user.detail', 'user.roles'])
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->take(50)
            ->get();

        // 12. Build Unified Activity & Interaction Histories
        $allActivityHistories = $this->buildUnifiedActivityHistories($user, $friendshipHistories, $profileLikeHistories, $chatHistories, $mediaHistories);

        return view('dashboard', compact(
            'user',
            'greeting',
            'lastLoginRecord',
            'userStats',
            'totalRoles',
            'totalPermissions',
            'rolesDistribution',
            'todayLogins',
            'activeOnlineCount',
            'chartDates',
            'chartLogins',
            'chartRegistrations',
            'backupFiles',
            'totalBackupSize',
            'lastBackupTime',
            'lastBackupName',
            'isMaintenance',
            'activeSectionsCount',
            'pendingApprovals',
            'pendingDeactivations',
            'recentLogins',
            'recentMessages',
            'contactUsers',
            'incomingFriendRequestsCount',
            'outgoingFriendRequestsCount',
            'totalFriendsCount',
            'totalProfileLikesCount',
            'friendshipHistories',
            'profileLikeHistories',
            'chatHistories',
            'mediaHistories',
            'allActivityHistories'
        ));
    }

    /**
     * Render tailored user metrics dashboard.
     */
    protected function renderUserDashboard($user, string $greeting, $lastLoginRecord)
    {
        // 1. Personal Login Stats & Points
        $totalMyLogins = UserLogin::where('user_id', $user->id)->count();
        $myPoints = $user->detail->points ?? ($totalMyLogins * 10);

        // 2. Personal Messages & Unread
        $unreadMessagesCount = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->where('deleted_for_receiver', false)
            ->count();

        $myRecentMessages = $this->getRecentConversations($user);

        // 3. Personal Notifications
        $unreadNotificationsCount = $user->unreadNotifications()->count();
        $myNotifications = $user->notifications()->latest()->take(5)->get();

        // 4. Profile Completeness Progress
        $completenessScore = 0;
        $totalFields = 8;
        if (!empty($user->name)) $completenessScore++;
        if (!empty($user->email)) $completenessScore++;
        if (!empty($user->avatar) && $user->avatar !== 'assets/images/users/avatar-1.jpg') $completenessScore++;
        if (!empty($user->detail->telepon)) $completenessScore++;
        if (!empty($user->detail->alamat_jalan)) $completenessScore++;
        if (!empty($user->detail->foto_ktp)) $completenessScore++;
        if (!empty($user->config->cover_image)) $completenessScore++;
        if (!empty($user->config->motto)) $completenessScore++;
        $completenessPercent = round(($completenessScore / $totalFields) * 100);

        // 5. My Recent Logins
        $myRecentLogins = UserLogin::where('user_id', $user->id)
            ->latest('login_at')
            ->take(6)
            ->get();

        // 6. Active Contacts & Team Directory (Full Widget) with Friendship & Like Indicators
        $contactUsers = $this->prepareContactsForDashboard($user);
        $rolesDistribution = Role::withCount('users')->get();

        // 7. Friendship & Likes Stats for Current User
        $incomingFriendRequestsCount = Friendship::where('receiver_id', $user->id)->pending()->count();
        $outgoingFriendRequestsCount = Friendship::where('sender_id', $user->id)->pending()->count();
        $totalFriendsCount = $user->friends_count;
        $totalProfileLikesCount = $user->profile_likes_count;

        // 8. Activity Histories for Directory Tabs
        $friendshipHistories = Friendship::with(['sender.detail', 'receiver.detail', 'sender.roles', 'receiver.roles'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
            })
            ->latest('updated_at')
            ->take(50)
            ->get();

        $profileLikeHistories = ProfileLike::with(['user.detail', 'targetUser.detail', 'user.roles', 'targetUser.roles'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('target_user_id', $user->id);
            })
            ->latest('created_at')
            ->take(50)
            ->get();

        $chatHistories = Message::with(['sender.detail', 'receiver.detail', 'sender.roles', 'receiver.roles'])
            ->where(function ($q) use ($user) {
                $q->where(function ($sq) use ($user) {
                    $sq->where('sender_id', $user->id)->where('deleted_for_sender', false);
                })->orWhere(function ($sq) use ($user) {
                    $sq->where('receiver_id', $user->id)->where('deleted_for_receiver', false);
                });
            })
            ->latest('created_at')
            ->take(50)
            ->get();

        $mediaHistories = UserMediaHistory::with(['user.detail', 'user.roles'])
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->take(50)
            ->get();

        // 12. Build Unified Activity & Interaction Histories
        $allActivityHistories = $this->buildUnifiedActivityHistories($user, $friendshipHistories, $profileLikeHistories, $chatHistories, $mediaHistories);

        return view('dashboard', compact(
            'user',
            'greeting',
            'lastLoginRecord',
            'totalMyLogins',
            'myPoints',
            'unreadMessagesCount',
            'myRecentMessages',
            'unreadNotificationsCount',
            'myNotifications',
            'completenessPercent',
            'myRecentLogins',
            'contactUsers',
            'rolesDistribution',
            'incomingFriendRequestsCount',
            'outgoingFriendRequestsCount',
            'totalFriendsCount',
            'totalProfileLikesCount',
            'friendshipHistories',
            'profileLikeHistories',
            'chatHistories',
            'mediaHistories',
            'allActivityHistories'
        ));
    }

    /**
     * Build unified activity and interaction histories collection for the dashboard.
     */
    protected function buildUnifiedActivityHistories(User $currentUser, $friendshipHistories, $profileLikeHistories, $chatHistories, $mediaHistories)
    {
        $activities = collect();

        // 1. Friendship Histories
        foreach ($friendshipHistories as $f) {
            $isSender = $f->sender_id === $currentUser->id;
            $partner = $isSender ? $f->receiver : $f->sender;
            $status = $f->status;

            $badgeClass = 'bg-secondary-subtle text-secondary';
            $statusLabel = 'Pertemanan';
            if ($status === 'accepted') {
                $badgeClass = 'bg-success-subtle text-success';
                $statusLabel = 'Berteman';
            } elseif ($status === 'pending') {
                $badgeClass = 'bg-warning-subtle text-warning';
                $statusLabel = 'Menunggu Konfirmasi';
            } elseif ($status === 'rejected') {
                $badgeClass = 'bg-danger-subtle text-danger';
                $statusLabel = 'Ajakan Ditolak';
            }

            $desc = $isSender
                ? 'Mengirim ajakan berteman kepada ' . ($partner->name ?? 'Pengguna')
                : ($partner->name ?? 'Pengguna') . ' mengirim ajakan berteman kepada Anda';

            if ($status === 'accepted') {
                $desc = 'Anda dan ' . ($partner->name ?? 'Pengguna') . ' telah terhubung sebagai teman';
            } elseif ($status === 'rejected') {
                $desc = 'Ajakan berteman dengan ' . ($partner->name ?? 'Pengguna') . ' telah ditolak';
            }

            $time = $f->updated_at ?? $f->created_at;

            $activities->push((object) [
                'id' => 'friendship_' . $f->id,
                'category' => 'friendship',
                'category_label' => 'Pertemanan',
                'category_badge' => 'bg-success-subtle text-success',
                'icon' => 'ti ti-user-check',
                'title' => $statusLabel,
                'status_badge' => $badgeClass,
                'description' => $desc,
                'user' => $partner ?: $currentUser,
                'partner_name' => $partner->name ?? 'Pengguna',
                'partner_id' => $partner->id ?? null,
                'time' => $time,
                'time_formatted' => $time ? $time->format('d M Y, H:i') . ' WIB' : '-',
                'time_diff' => $time ? $time->diffForHumans() : '',
                'search_text' => strtolower('pertemanan ' . ($partner->name ?? '') . ' ' . $desc . ' ' . $statusLabel),
            ]);
        }

        // 2. Profile Like Histories
        foreach ($profileLikeHistories as $l) {
            $isSender = $l->user_id === $currentUser->id;
            $partner = $isSender ? $l->targetUser : $l->user;

            $desc = $isSender
                ? 'Anda memberikan apresiasi suka pada profil ' . ($partner->name ?? 'Pengguna')
                : ($partner->name ?? 'Pengguna') . ' menyukai profil Anda ❤️';

            $time = $l->created_at;

            $activities->push((object) [
                'id' => 'like_' . $l->id,
                'category' => 'like',
                'category_label' => 'Suka Profil',
                'category_badge' => 'bg-danger-subtle text-danger',
                'icon' => 'ti ti-heart-filled',
                'title' => $isSender ? 'Menyukai Profil' : 'Menerima Suka',
                'status_badge' => 'bg-danger-subtle text-danger',
                'description' => $desc,
                'user' => $partner ?: $currentUser,
                'partner_name' => $partner->name ?? 'Pengguna',
                'partner_id' => $partner->id ?? null,
                'time' => $time,
                'time_formatted' => $time ? $time->format('d M Y, H:i') . ' WIB' : '-',
                'time_diff' => $time ? $time->diffForHumans() : '',
                'search_text' => strtolower('suka like profil ' . ($partner->name ?? '') . ' ' . $desc),
            ]);
        }

        // 3. Chat Messages Histories
        foreach ($chatHistories as $m) {
            $isSender = $m->sender_id === $currentUser->id;
            $partner = $isSender ? $m->receiver : $m->sender;

            $msgText = $m->message ?: ($m->attachment_name ? '[Lampiran: ' . $m->attachment_name . ']' : '[Lampiran Berkas]');
            $desc = $isSender
                ? 'Mengirim pesan ke ' . ($partner->name ?? 'Pengguna') . ': "' . \Illuminate\Support\Str::limit($msgText, 50) . '"'
                : 'Menerima pesan dari ' . ($partner->name ?? 'Pengguna') . ': "' . \Illuminate\Support\Str::limit($msgText, 50) . '"';

            $time = $m->created_at;

            $activities->push((object) [
                'id' => 'chat_' . $m->id,
                'category' => 'chat',
                'category_label' => 'Obrolan Chat',
                'category_badge' => 'bg-info-subtle text-info',
                'icon' => 'ti ti-messages',
                'title' => $isSender ? 'Pesan Terkirim' : 'Pesan Masuk',
                'status_badge' => $m->is_read ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning',
                'description' => $desc,
                'user' => $partner ?: $currentUser,
                'partner_name' => $partner->name ?? 'Pengguna',
                'partner_id' => $partner->id ?? null,
                'chat_user_id' => $partner->id ?? null,
                'time' => $time,
                'time_formatted' => $time ? $time->format('d M Y, H:i') . ' WIB' : '-',
                'time_diff' => $time ? $time->diffForHumans() : '',
                'search_text' => strtolower('chat pesan obrolan ' . ($partner->name ?? '') . ' ' . $desc . ' ' . $msgText),
            ]);
        }

        // 4. Media Histories (Avatar & Cover)
        foreach ($mediaHistories as $mh) {
            $isAvatar = $mh->media_type === 'avatar';
            $title = $isAvatar ? 'Ganti Foto Avatar' : 'Ganti Foto Sampul';
            $desc = ($mh->description ?: $title) . ($mh->file_name ? ' (' . $mh->file_name . ')' : '');

            $time = $mh->created_at;

            $activities->push((object) [
                'id' => 'media_' . $mh->id,
                'category' => 'media',
                'category_label' => 'Avatar & Sampul',
                'category_badge' => $isAvatar ? 'bg-primary-subtle text-primary' : 'bg-purple-subtle text-purple',
                'icon' => $isAvatar ? 'ti ti-user-circle' : 'ti ti-photo',
                'title' => $title,
                'status_badge' => $isAvatar ? 'bg-primary-subtle text-primary' : 'bg-purple-subtle text-purple',
                'description' => $desc,
                'user' => $currentUser,
                'partner_name' => $currentUser->name,
                'partner_id' => null,
                'time' => $time,
                'time_formatted' => $time ? $time->format('d M Y, H:i') . ' WIB' : '-',
                'time_diff' => $time ? $time->diffForHumans() : '',
                'search_text' => strtolower('media avatar sampul ' . $desc . ' ' . ($mh->file_name ?? '') . ' ' . $title),
            ]);
        }

        return $activities->sortByDesc('time')->values();
    }

    /**
     * Prepare contacts with friendship status and like indicators.
     */
    protected function prepareContactsForDashboard(User $currentUser)
    {
        $contacts = User::with(['config', 'detail', 'roles', 'profileLikesReceived', 'sentFriendships', 'receivedFriendships'])
            ->where('status', 'active')
            ->get();

        foreach ($contacts as $cUser) {
            $friendship = $currentUser->getFriendshipWith($cUser);
            $cUser->friendship_status = $friendship['status'];
            $cUser->friendship_model = $friendship['friendship'];
            $cUser->is_liked_by_me = $cUser->isLikedBy($currentUser);
        }

        // Urutan prioritas:
        // 0. Akun sendiri
        // 1. Teman & Online
        // 2. Teman & Offline
        // 3. Bukan teman & Online
        // 4. Bukan teman & Offline
        return $contacts->sort(function ($a, $b) use ($currentUser) {
            $rankA = $this->getUserDisplayRank($a, $currentUser);
            $rankB = $this->getUserDisplayRank($b, $currentUser);

            if ($rankA !== $rankB) {
                return $rankA <=> $rankB;
            }

            return strcasecmp($a->name, $b->name);
        })->values();
    }

    /**
     * Calculate display rank for contact sorting priority.
     */
    protected function getUserDisplayRank(User $u, User $currentUser): int
    {
        if ($u->id === $currentUser->id) {
            return 0; // Widget kita sendiri
        }

        $isFriend = ($u->friendship_status === 'friends');
        $isOnline = (bool) $u->is_online;

        if ($isFriend && $isOnline) {
            return 1; // Teman dan sedang Online
        }
        if ($isFriend && !$isOnline) {
            return 2; // Teman dan Offline
        }
        if (!$isFriend && $isOnline) {
            return 3; // Bukan teman tetapi sedang Online
        }

        return 4; // Bukan teman dan Offline
    }

    /**
     * Get distinct recent conversations (one item per contact partner).
     */
    protected function getRecentConversations($user)
    {
        $allMessages = Message::with(['sender', 'receiver'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->where(function ($q) use ($user) {
                $q->where(function ($sq) use ($user) {
                    $sq->where('sender_id', $user->id)->where('deleted_for_sender', false);
                })->orWhere(function ($sq) use ($user) {
                    $sq->where('receiver_id', $user->id)->where('deleted_for_receiver', false);
                });
            })
            ->latest('created_at')
            ->get();

        $conversations = collect();
        $seenPartners = [];

        foreach ($allMessages as $msg) {
            $partnerId = $msg->sender_id === $user->id ? $msg->receiver_id : $msg->sender_id;
            if (!in_array($partnerId, $seenPartners)) {
                $seenPartners[] = $partnerId;
                $conversations->push($msg);
                if ($conversations->count() >= 5) {
                    break;
                }
            }
        }

        return $conversations;
    }

    /**
     * Get dynamic greeting based on current local hour (WIB / Asia/Jakarta).
     */
    protected function getTimeGreeting(): string
    {
        // Gunakan Waktu Indonesia Barat (WIB) secara presisi
        $hour = (int) Carbon::now('Asia/Jakarta')->format('H');

        if ($hour >= 4 && $hour < 11) {
            return 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }

    /**
     * Run php artisan optimize:clear and clear custom application caches.
     */
    public function optimizeClear()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            \App\Models\Admin\DukunganAplikasi\FiturAplikasi::clearCache();
            \App\Models\Admin\DukunganAplikasi\ProfilAplikasi::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Perintah "php artisan optimize:clear" berhasil dijalankan! Seluruh cache sistem (Config, Views, Routes, Events, Compiled) telah dibersihkan.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menjalankan optimize:clear: ' . $e->getMessage(),
            ], 500);
        }
    }
}
