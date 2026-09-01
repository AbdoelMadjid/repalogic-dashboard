<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\ProfileLike;
use App\Models\User;
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
            'motto' => $currentUser->motto ?? '',
            'login_count' => $currentUser->login_count ?? 0,
        ];

        return response()->json([
            'success' => true,
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
}
