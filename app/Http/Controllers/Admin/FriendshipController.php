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

class FriendshipController extends Controller
{
    use HasNotification;

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

            if ($existing->status === 'rejected') {
                $existing->update([
                    'sender_id' => $currentUser->id,
                    'receiver_id' => $user->id,
                    'status' => 'pending',
                ]);
                $friendship = $existing;
            }
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
        $friendship = Friendship::with('sender')->where('id', $id)
            ->where('receiver_id', $currentUser->id)
            ->firstOrFail();

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
        $friendship = Friendship::with('sender')->where('id', $id)
            ->where('receiver_id', $currentUser->id)
            ->firstOrFail();

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
