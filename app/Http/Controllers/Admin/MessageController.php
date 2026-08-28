<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display main chat & messaging dashboard.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        // Ambil daftar seluruh pengguna lain (selain user aktif)
        $users = User::where('id', '!=', $currentUser->id)
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        // Ambil pesan terakhir & pisahkan kontak yang sudah obrolan vs pengguna baru
        $recentContacts = collect();
        $otherContacts = collect();

        foreach ($users as $u) {
            $convId = Message::makeConversationId($currentUser->id, $u->id);
            $lastMsg = Message::where('conversation_id', $convId)->latest()->first();
            $unreadCount = Message::where('conversation_id', $convId)
                ->where('receiver_id', $currentUser->id)
                ->where('is_read', false)
                ->count();

            $cData = [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'avatar' => $u->avatar_url,
                'role_name' => $u->role_name,
                'last_message' => $lastMsg ? $lastMsg->body : 'Belum ada obrolan.',
                'last_message_time' => $lastMsg && $lastMsg->created_at ? $lastMsg->created_at->diffForHumans() : '',
                'last_message_raw' => $lastMsg ? $lastMsg->created_at : null,
                'unread_count' => $unreadCount,
            ];

            if ($lastMsg !== null) {
                $recentContacts->push($cData);
            } else {
                $otherContacts->push($cData);
            }
        }

        // Urutkan obrolan aktif dari pesan paling baru
        $recentContacts = $recentContacts->sortByDesc('last_message_raw')->values();

        // Tentukan user target obrolan aktif (hanya jika ada parameter ?user_id=X di URL)
        $targetUserId = $request->query('user_id');
        $activeUser = null;

        if ($targetUserId) {
            $activeUser = $users->firstWhere('id', (int) $targetUserId);
        }

        // Ambil seluruh pesan antara user aktif dan activeUser (hanya jika user_id ditentukan)
        $messages = collect();
        if ($activeUser) {
            $convId = Message::makeConversationId($currentUser->id, $activeUser->id);
            $messages = Message::where('conversation_id', $convId)
                ->orderBy('created_at', 'asc')
                ->get();

            // Tandai pesan belum dibaca dari activeUser sebagai sudah dibaca
            Message::where('conversation_id', $convId)
                ->where('receiver_id', $currentUser->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        }

        return view('admin.profil-pengguna.messages', compact('recentContacts', 'otherContacts', 'activeUser', 'messages'));
    }

    /**
     * Fetch conversation messages via AJAX for target user.
     */
    public function getMessages(Request $request, int $userId): JsonResponse
    {
        $currentUser = Auth::user();
        $targetUser = User::findOrFail($userId);

        $convId = Message::makeConversationId($currentUser->id, $targetUser->id);

        // Tandai pesan belum dibaca dari targetUser sebagai sudah dibaca
        Message::where('conversation_id', $convId)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $messages = Message::where('conversation_id', $convId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($currentUser) {
                return [
                    'id' => $msg->id,
                    'is_sender' => $msg->sender_id === $currentUser->id,
                    'body' => $msg->body,
                    'reason' => $msg->reason,
                    'subject' => $msg->subject,
                    'message_type' => $msg->message_type,
                    'time_formatted' => $msg->created_at ? $msg->created_at->format('H:i') : '',
                    'date_formatted' => $msg->created_at ? $msg->created_at->format('d M Y') : '',
                    'sender_name' => $msg->sender ? $msg->sender->name : 'Sistem',
                    'sender_avatar' => $msg->sender ? $msg->sender->avatar_url : asset('assets/images/users/default-avatar.svg'),
                ];
            });

        return response()->json([
            'success' => true,
            'target_user' => [
                'id' => $targetUser->id,
                'name' => $targetUser->name,
                'email' => $targetUser->email,
                'avatar' => $targetUser->avatar_url,
                'role_name' => $targetUser->role_name,
                'status' => ucfirst($targetUser->status),
                'joined_at' => $targetUser->created_at ? $targetUser->created_at->format('d M Y') : '-',
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Send new direct chat message via AJAX.
     */
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'receiver_id' => ['required', 'integer', 'exists:users,id'],
            'body' => ['required', 'string', 'max:2000'],
        ], [
            'receiver_id.required' => 'Penerima pesan wajib ditentukan.',
            'body.required' => 'Isi pesan tidak boleh kosong.',
        ]);

        $currentUser = Auth::user();
        $receiverId = (int) $validated['receiver_id'];

        if ($receiverId === $currentUser->id) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat mengirim pesan ke diri sendiri.'], 422);
        }

        $convId = Message::makeConversationId($currentUser->id, $receiverId);

        $msg = Message::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $receiverId,
            'conversation_id' => $convId,
            'body' => trim($validated['body']),
            'message_type' => 'direct',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $msg->id,
                'is_sender' => true,
                'body' => $msg->body,
                'time_formatted' => $msg->created_at ? $msg->created_at->format('H:i') : 'Baru saja',
                'sender_avatar' => $currentUser->avatar_url,
            ],
        ]);
    }
}
