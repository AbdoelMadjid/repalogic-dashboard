<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\ProfileLike;
use App\Models\User;
use App\Models\UserMediaHistory;
use App\Traits\HasNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendshipController extends Controller
{
    use HasNotification;

    /**
     * Poll real-time friendship updates, like counts, online presence, and requests for the dashboard.
     */
    public function pollDashboard(Request $request): JsonResponse
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return response()->json(['success' => false], 401);
        }

        // Bulk fetch all friendships involving currentUser
        $allMyFriendships = Friendship::where('sender_id', $currentUser->id)
            ->orWhere('receiver_id', $currentUser->id)
            ->get();

        $friendshipsMap = [];
        $incomingCount = 0;
        $outgoingCount = 0;
        $friendsCount = 0;

        foreach ($allMyFriendships as $f) {
            $otherId = $f->sender_id === $currentUser->id ? $f->receiver_id : $f->sender_id;
            if ($f->status === 'accepted') {
                $status = 'friends';
                $friendsCount++;
            } elseif ($f->status === 'pending') {
                if ($f->sender_id === $currentUser->id) {
                    $status = 'pending_sent';
                    $outgoingCount++;
                } else {
                    $status = 'pending_received';
                    $incomingCount++;
                }
            } else {
                $status = 'none';
            }
            $friendshipsMap[$otherId] = [
                'status' => $status,
                'id' => $f->id,
            ];
        }

        // Bulk fetch like counts per target_user_id
        $likesCountMap = ProfileLike::select('target_user_id', DB::raw('count(*) as total'))
            ->groupBy('target_user_id')
            ->pluck('total', 'target_user_id')
            ->all();

        // Bulk fetch all users liked by currentUser
        $myLikesMap = ProfileLike::where('user_id', $currentUser->id)
            ->pluck('target_user_id')
            ->flip()
            ->all();

        $profileLikesCount = $likesCountMap[$currentUser->id] ?? 0;

        $users = User::with(['config', 'detail', 'roles'])
            ->where('status', 'active')
            ->get();

        $contactsData = [];
        foreach ($users as $u) {
            $isMe = $u->id === $currentUser->id;
            $fInfo = $friendshipsMap[$u->id] ?? ['status' => 'none', 'id' => null];

            $contactsData[$u->id] = [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'avatar_url' => $u->avatar_url,
                'cover_bg_url' => $u->cover_bg_url,
                'cover_position_y' => $u->cover_position_y ?? 50,
                'cover_height' => $u->cover_height ?? 320,
                'cover_color' => $u->cover_color ?: '#313a46',
                'cover_opacity' => $u->cover_opacity ?? 60,
                'cover_blur' => $u->cover_blur ?? 0,
                'motto' => $u->motto ?? '',
                'pekerjaan' => $u->detail->pekerjaan ?? 'Belum diisi',
                'telepon' => $u->detail->telepon ?? '',
                'telepon_wa_url' => $u->detail->telepon_wa_url ?? '',
                'kabupaten_kota' => $u->detail->kabupaten_kota ?? 'Belum diisi',
                'login_count' => $u->login_count ?? 0,
                'created_at_formatted' => $u->created_at ? $u->created_at->format('d M Y') : '',
                'is_online' => $u->is_online,
                'last_seen' => $u->last_seen_human,
                'friendship_status' => $isMe ? 'self' : $fInfo['status'],
                'friendship_id' => $fInfo['id'],
                'likes_count' => $likesCountMap[$u->id] ?? 0,
                'is_liked_by_me' => isset($myLikesMap[$u->id]),
            ];
        }

        $currentUserData = [
            'id' => $currentUser->id,
            'name' => $currentUser->name,
            'email' => $currentUser->email,
            'avatar_url' => $currentUser->avatar_url,
            'cover_bg_url' => $currentUser->cover_bg_url,
            'cover_position_y' => $currentUser->cover_position_y ?? 50,
            'cover_height' => $currentUser->cover_height ?? 320,
            'cover_color' => $currentUser->cover_color ?: '#313a46',
            'cover_opacity' => $currentUser->cover_opacity ?? 60,
            'cover_blur' => $currentUser->cover_blur ?? 0,
            'motto' => $currentUser->motto ?? '',
            'login_count' => $currentUser->login_count ?? 0,
        ];

        return response()->json([
            'success' => true,
            'friendsCount' => $friendsCount,
            'profileLikesCount' => $profileLikesCount,
            'incomingCount' => $incomingCount,
            'outgoingCount' => $outgoingCount,
            'current_user' => $currentUserData,
            'stats' => [
                'friends_count' => $friendsCount,
                'profile_likes_count' => $profileLikesCount,
                'incoming_requests_count' => $incomingCount,
                'outgoing_requests_count' => $outgoingCount,
                'total_users' => count($contactsData),
            ],
            'contacts' => $contactsData,
        ]);
    }

    /**
     * Toggle like/unlike for a user's profile.
     */
    public function toggleLike(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $user->id) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menyukai profil sendiri.',
                ], 422);
            }
            $this->notifyWarning('Anda tidak dapat menyukai profil sendiri.', 'Peringatan');
            return back();
        }

        $existingLike = ProfileLike::where('user_id', $currentUser->id)
            ->where('target_user_id', $user->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
            $message = 'Batal menyukai profil ' . $user->name;
        } else {
            ProfileLike::create([
                'user_id' => $currentUser->id,
                'target_user_id' => $user->id,
            ]);
            $liked = true;
            $message = 'Anda menyukai profil ' . $user->name . ' ❤️';
        }

        $likesCount = ProfileLike::where('target_user_id', $user->id)->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $likesCount,
                'message' => $message,
            ]);
        }

        $this->notifySuccess($message, 'Berhasil', 'toast');
        return back();
    }

    /**
     * Send a friend request to a user.
     */
    public function sendRequest(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $user->id) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat mengirim ajakan berteman ke diri sendiri.',
                ], 422);
            }
            $this->notifyWarning('Anda tidak dapat mengirim ajakan berteman ke diri sendiri.', 'Peringatan');
            return back();
        }

        // Check if there is already a friendship record
        $existing = Friendship::where(function ($q) use ($currentUser, $user) {
            $q->where('sender_id', $currentUser->id)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($currentUser, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $currentUser->id);
        })->first();

        if ($existing) {
            if ($existing->status === 'accepted') {
                $msg = 'Anda sudah berteman dengan ' . $user->name . '.';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'status' => 'friends', 'message' => $msg]);
                }
                $this->notifyInfo($msg, 'Informasi');
                return back();
            }

            if ($existing->sender_id === $currentUser->id && $existing->status === 'pending') {
                $msg = 'Ajakan berteman sudah pernah dikirimkan sebelumnya.';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'status' => 'pending_sent', 'message' => $msg]);
                }
                $this->notifyInfo($msg, 'Informasi');
                return back();
            }

            if ($existing->receiver_id === $currentUser->id && $existing->status === 'pending') {
                // If they already sent request to us, auto-accept it!
                $existing->update(['status' => 'accepted']);
                $msg = 'Ajakan berteman dari ' . $user->name . ' telah diterima!';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'status' => 'friends', 'message' => $msg]);
                }
                $this->notifySuccess($msg, 'Berteman!');
                return back();
            }

            // Jika sebelumnya pernah ditolak atau status lain, perbarui menjadi pending
            $existing->update([
                'sender_id' => $currentUser->id,
                'receiver_id' => $user->id,
                'status' => 'pending',
            ]);
            $friendship = $existing;
        } else {
            $friendship = Friendship::create([
                'sender_id' => $currentUser->id,
                'receiver_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        $message = 'Ajakan berteman berhasil dikirimkan ke ' . $user->name . '.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'pending_sent',
                'friendship_id' => $friendship->id ?? null,
                'message' => $message,
            ]);
        }

        $this->notifySuccess($message, 'Ajakan Terkirim', 'toast');
        return back();
    }

    /**
     * Accept an incoming friend request.
     */
    public function acceptRequest(Request $request, $id)
    {
        $currentUser = Auth::user();
        $friendship = Friendship::with('sender')
            ->where(function ($q) use ($id, $currentUser) {
                $q->where('id', $id)
                    ->orWhere(function ($sq) use ($id, $currentUser) {
                        $sq->where('sender_id', $id)
                            ->where('receiver_id', $currentUser->id);
                    });
            })
            ->where('receiver_id', $currentUser->id)
            ->first();

        if (!$friendship) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ajakan berteman tidak ditemukan atau sudah diproses.',
                ], 404);
            }
            $this->notifyError('Ajakan berteman tidak ditemukan.');
            return back();
        }

        $friendship->update(['status' => 'accepted']);
        $senderName = $friendship->sender->name ?? 'Pengguna';

        $message = 'Anda sekarang berteman dengan ' . $senderName . '!';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'friends',
                'sender_id' => $friendship->sender_id,
                'message' => $message,
            ]);
        }

        $this->notifySuccess($message, 'Pertemanan Diterima');
        return back();
    }

    /**
     * Reject an incoming friend request.
     */
    public function rejectRequest(Request $request, $id)
    {
        $currentUser = Auth::user();
        $friendship = Friendship::with('sender')
            ->where(function ($q) use ($id, $currentUser) {
                $q->where('id', $id)
                    ->orWhere(function ($sq) use ($id, $currentUser) {
                        $sq->where('sender_id', $id)
                            ->where('receiver_id', $currentUser->id);
                    });
            })
            ->where('receiver_id', $currentUser->id)
            ->first();

        if (!$friendship) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ajakan berteman tidak ditemukan atau sudah diproses.',
                ], 404);
            }
            $this->notifyError('Ajakan berteman tidak ditemukan.');
            return back();
        }

        $senderName = $friendship->sender->name ?? 'Pengguna';
        $senderId = $friendship->sender_id;

        $friendship->delete();

        $message = 'Ajakan berteman dari ' . $senderName . ' ditolak.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'none',
                'sender_id' => $senderId,
                'message' => $message,
            ]);
        }

        $this->notifyInfo($message, 'Ditolak');
        return back();
    }

    /**
     * Cancel an outgoing pending friend request.
     */
    public function cancelRequest(Request $request, User $user)
    {
        $currentUser = Auth::user();

        Friendship::where('sender_id', $currentUser->id)
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->delete();

        $message = 'Ajakan berteman ke ' . $user->name . ' telah dibatalkan.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'none',
                'target_id' => $user->id,
                'message' => $message,
            ]);
        }

        $this->notifyInfo($message, 'Dibatalkan');
        return back();
    }

    /**
     * Unfriend a user.
     */
    public function unfriend(Request $request, User $user)
    {
        $currentUser = Auth::user();

        Friendship::where(function ($q) use ($currentUser, $user) {
            $q->where('sender_id', $currentUser->id)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($currentUser, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $currentUser->id);
        })->where('status', 'accepted')->delete();

        $message = 'Anda telah menghapus ' . $user->name . ' dari daftar teman.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'none',
                'target_id' => $user->id,
                'message' => $message,
            ]);
        }

        $this->notifyInfo($message, 'Pertemanan Dihapus');
        return back();
    }

    /**
     * Get detailed user interaction history (friendship, likes, messages, avatar & cover changes).
     */
    public function getUserHistory(Request $request, User $user): JsonResponse
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $friendship = $currentUser->getFriendshipWith($user);
        $friendshipModel = $friendship['friendship'];

        $isLikedByMe = $user->isLikedBy($currentUser);
        $isLikingMe = $currentUser->isLikedBy($user);

        // All friendship logs involving this target user
        $friendshipLogs = Friendship::with(['sender', 'receiver'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->latest('updated_at')
            ->take(20)
            ->get()
            ->map(function ($f) use ($user) {
                return [
                    'id' => $f->id,
                    'status' => $f->status,
                    'is_sender' => $f->sender_id === $user->id,
                    'sender_name' => $f->sender?->name ?? 'User',
                    'receiver_name' => $f->receiver?->name ?? 'User',
                    'created_at_human' => $f->created_at ? $f->created_at->diffForHumans() : '-',
                    'created_at_formatted' => $f->created_at ? $f->created_at->format('d M Y H:i') . ' WIB' : '-',
                    'updated_at_formatted' => $f->updated_at ? $f->updated_at->format('d M Y H:i') . ' WIB' : '-',
                ];
            });

        // Messages exchanged between current user and target user
        $messages = Message::where(function ($q) use ($currentUser, $user) {
                $q->where('sender_id', $currentUser->id)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($currentUser, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $currentUser->id);
            })
            ->latest('created_at')
            ->take(15)
            ->get()
            ->reverse()
            ->values()
            ->map(function ($m) use ($currentUser) {
                return [
                    'id' => $m->id,
                    'is_me' => $m->sender_id === $currentUser->id,
                    'message' => $m->message,
                    'attachment_path' => $m->attachment_path,
                    'attachment_name' => $m->attachment_name,
                    'attachment_type' => $m->attachment_type,
                    'is_read' => (bool) $m->is_read,
                    'time_formatted' => $m->created_at ? $m->created_at->format('H:i') : '',
                    'date_formatted' => $m->created_at ? $m->created_at->format('d M Y') : '',
                ];
            });

        // Media changes (avatar and cover) of target user
        $mediaHistories = UserMediaHistory::where('user_id', $user->id)
            ->latest('created_at')
            ->take(20)
            ->get()
            ->map(function ($mh) {
                return [
                    'id' => $mh->id,
                    'media_type' => $mh->media_type,
                    'url' => $mh->url,
                    'file_name' => $mh->file_name,
                    'description' => $mh->description,
                    'meta' => $mh->meta_data,
                    'time_formatted' => $mh->created_at ? $mh->created_at->format('d M Y H:i') . ' WIB' : '-',
                    'time_human' => $mh->created_at ? $mh->created_at->diffForHumans() : '-',
                ];
            });

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url,
                'cover_bg_url' => $user->cover_bg_url,
                'cover_position_y' => $user->cover_position_y ?? 50,
                'role_name' => $user->role_name,
                'is_online' => (bool) $user->is_online,
                'motto' => $user->motto,
                'telepon' => $user->detail->telepon ?? '',
                'pekerjaan' => $user->detail->pekerjaan ?? '',
                'kabupaten_kota' => $user->detail->kabupaten_kota ?? '',
                'friends_count' => $user->friends_count,
                'profile_likes_count' => $user->profile_likes_count,
                'login_count' => $user->login_count ?? 0,
            ],
            'friendship' => [
                'status' => $friendship['status'],
                'id' => $friendshipModel?->id,
                'created_at_formatted' => $friendshipModel?->created_at ? $friendshipModel->created_at->format('d M Y H:i') . ' WIB' : null,
                'updated_at_formatted' => $friendshipModel?->updated_at ? $friendshipModel->updated_at->format('d M Y H:i') . ' WIB' : null,
            ],
            'likes' => [
                'is_liked_by_me' => $isLikedByMe,
                'is_liking_me' => $isLikingMe,
                'total_likes' => $user->profile_likes_count,
            ],
            'messages' => $messages,
            'media_histories' => $mediaHistories,
            'friendship_logs' => $friendshipLogs,
        ]);
    }
}
