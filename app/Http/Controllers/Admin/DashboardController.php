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
            'totalProfileLikesCount'
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
            'totalProfileLikesCount'
        ));
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
}
