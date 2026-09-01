<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Display main chat & messaging dashboard.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        // Ambil daftar seluruh pengguna lain (selain user aktif)
        $users = User::with('config')
            ->where('id', '!=', $currentUser->id)
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        // Ambil pesan terakhir & pisahkan kontak yang sudah obrolan vs pengguna baru
        $recentContacts = collect();
        $otherContacts = collect();

        foreach ($users as $u) {
            $convId = Message::makeConversationId($currentUser->id, $u->id);
            $lastMsg = Message::where('conversation_id', $convId)->visibleTo($currentUser->id)->latest()->first();
            $unreadCount = Message::where('conversation_id', $convId)
                ->where('receiver_id', $currentUser->id)
                ->where('is_read', false)
                ->where('deleted_for_receiver', false)
                ->count();

            $cData = [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'avatar' => $u->avatar_url,
                'cover_bg_url' => $u->cover_bg_url,
                'cover_position_y' => $u->cover_position_y,
                'motto' => $u->motto,
                'role_name' => $u->role_name,
                'is_online' => $u->is_online,
                'last_seen_human' => $u->last_seen_human,
                'last_message' => $this->getDisplayLastMessage($lastMsg),
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
            $messages = Message::with(['sender', 'parent.sender'])
                ->where('conversation_id', $convId)
                ->visibleTo($currentUser->id)
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
     * Poll contacts status and unread counts for real-time sidebar sync.
     */
    public function pollContacts(Request $request): JsonResponse
    {
        $currentUser = Auth::user();

        $users = User::with('config')
            ->where('id', '!=', $currentUser->id)
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        $contacts = [];
        $recentCount = 0;
        $otherCount = 0;

        foreach ($users as $u) {
            $convId = Message::makeConversationId($currentUser->id, $u->id);
            $lastMsg = Message::where('conversation_id', $convId)->visibleTo($currentUser->id)->latest()->first();
            $unreadCount = Message::where('conversation_id', $convId)
                ->where('receiver_id', $currentUser->id)
                ->where('is_read', false)
                ->where('deleted_for_receiver', false)
                ->count();

            if ($lastMsg !== null) {
                $recentCount++;
            } else {
                $otherCount++;
            }

            $contacts[] = [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'avatar' => $u->avatar_url,
                'cover_bg_url' => $u->cover_bg_url,
                'cover_position_y' => $u->cover_position_y,
                'motto' => $u->motto,
                'role_name' => $u->role_name,
                'is_online' => $u->is_online,
                'last_seen_human' => $u->last_seen_human,
                'last_message' => $this->getDisplayLastMessage($lastMsg),
                'last_message_time' => $lastMsg && $lastMsg->created_at ? $lastMsg->created_at->diffForHumans() : '',
                'last_message_raw' => $lastMsg && $lastMsg->created_at ? $lastMsg->created_at->timestamp : 0,
                'has_conversation' => $lastMsg !== null,
                'unread_count' => $unreadCount,
            ];
        }

        return response()->json([
            'success' => true,
            'current_user_avatar' => $currentUser->avatar_url,
            'contacts' => $contacts,
            'recent_count' => $recentCount,
            'other_count' => $otherCount,
        ]);
    }

    /**
     * Fetch conversation messages via AJAX for target user.
     */
    public function getMessages(Request $request, $user): JsonResponse
    {
        $currentUser = Auth::user();
        $targetUser = $user instanceof User ? $user : User::with('config')->findOrFail((int) $user);

        $convId = Message::makeConversationId($currentUser->id, $targetUser->id);

        // Tandai pesan belum dibaca dari targetUser sebagai sudah dibaca
        Message::where('conversation_id', $convId)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $messages = Message::with(['sender', 'parent.sender'])
            ->where('conversation_id', $convId)
            ->visibleTo($currentUser->id)
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
                    'attachment_url' => $msg->attachment_url,
                    'attachment_name' => $msg->attachment_name,
                    'attachment_type' => $msg->attachment_type,
                    'attachment_size' => $msg->attachment_size,
                    'attachment_size_formatted' => $msg->attachment_size ? $this->formatFileSize($msg->attachment_size) : null,
                    'parent_id' => $msg->parent_id,
                    'is_pinned' => (bool) $msg->is_pinned,
                    'reactions' => $msg->reactions ?: [],
                    'is_forwarded' => (bool) $msg->is_forwarded,
                    'parent' => $msg->parent ? [
                        'id' => $msg->parent->id,
                        'sender_name' => $msg->parent->sender ? ($msg->parent->sender_id === $currentUser->id ? 'Anda' : $msg->parent->sender->name) : 'Pesan',
                        'body' => $msg->parent->body ?: ($msg->parent->attachment_name ?: 'Lampiran berkas'),
                    ] : null,
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
                'telepon' => $targetUser->detail?->telepon,
                'telepon_wa_url' => $targetUser->detail?->telepon_wa_url,
                'avatar' => $targetUser->avatar_url,
                'cover_bg_url' => $targetUser->cover_bg_url,
                'cover_position_y' => $targetUser->cover_position_y,
                'motto' => $targetUser->motto,
                'role_name' => $targetUser->role_name,
                'status' => ucfirst($targetUser->status),
                'joined_at' => $targetUser->created_at ? $targetUser->created_at->format('d M Y') : '-',
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Send new direct chat message (with text, reply quote, image, audio, or document attachment) via AJAX.
     */
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'receiver_id' => ['required', 'integer', 'exists:users,id'],
            'body' => ['nullable', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx,xls,xlsx,zip,rar,txt,mp3,wav,ogg,webm,m4a,mp4,aac,flac'],
        ], [
            'receiver_id.required' => 'Penerima pesan wajib ditentukan.',
            'attachment.max' => 'Ukuran lampiran maksimal 10 MB.',
            'attachment.mimes' => 'Format berkas harus berupa Gambar, Audio/Voice Note, atau Dokumen (PDF, DOC, XLS, ZIP, TXT).',
        ]);

        $bodyText = $request->filled('body') ? trim($validated['body']) : '';
        $hasAttachment = $request->hasFile('attachment');

        if ($bodyText === '' && !$hasAttachment) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan atau lampiran berkas wajib diisi.'
            ], 422);
        }

        $currentUser = Auth::user();
        $receiverId = (int) $validated['receiver_id'];
        
        $parentId = null;
        if ($request->filled('parent_id') && is_numeric($request->input('parent_id'))) {
            $parentId = (int) $request->input('parent_id');
            $request->validate(['parent_id' => 'exists:messages,id']);
        }

        if ($receiverId === $currentUser->id) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat mengirim pesan ke diri sendiri.'], 422);
        }

        $parentMessage = null;
        if ($parentId) {
            $parentMessage = Message::with('sender')->find($parentId);
        }

        // Handle upload berkas/gambar/audio jika ada
        $attachmentUrl = null;
        $attachmentName = null;
        $attachmentType = null;
        $attachmentSize = null;

        if ($hasAttachment) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $ext = strtolower($file->getClientOriginalExtension());
            $size = $file->getSize();

            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
            $isVoice = in_array($ext, ['mp3', 'wav', 'ogg', 'webm', 'm4a', 'aac', 'flac']) || str_starts_with($file->getMimeType() ?? '', 'audio/');

            if ($isImage) {
                $attachmentType = 'image';
            } elseif ($isVoice) {
                $attachmentType = 'voice';
            } else {
                $attachmentType = 'file';
            }

            $filename = 'chat_' . time() . '_' . uniqid() . '.' . ($ext ?: 'webm');
            $file->storeAs('chat_attachments', $filename, 'public');

            $attachmentUrl = asset('storage/chat_attachments/' . $filename);
            $attachmentName = $attachmentType === 'voice' ? 'Pesan Suara' : $originalName;
            $attachmentSize = $size;
        }

        $convId = Message::makeConversationId($currentUser->id, $receiverId);

        $msg = Message::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $receiverId,
            'conversation_id' => $convId,
            'parent_id' => $parentMessage ? $parentMessage->id : null,
            'body' => $bodyText,
            'attachment_url' => $attachmentUrl,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
            'attachment_size' => $attachmentSize,
            'message_type' => 'direct',
            'is_read' => false,
            'is_pinned' => false,
            'reactions' => null,
            'is_forwarded' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $msg->id,
                'is_sender' => true,
                'body' => $msg->body,
                'attachment_url' => $msg->attachment_url,
                'attachment_name' => $msg->attachment_name,
                'attachment_type' => $msg->attachment_type,
                'attachment_size' => $msg->attachment_size,
                'attachment_size_formatted' => $msg->attachment_size ? $this->formatFileSize($msg->attachment_size) : null,
                'parent_id' => $msg->parent_id,
                'is_pinned' => false,
                'reactions' => [],
                'is_forwarded' => false,
                'parent' => $parentMessage ? [
                    'id' => $parentMessage->id,
                    'sender_name' => $parentMessage->sender ? ($parentMessage->sender_id === $currentUser->id ? 'Anda' : $parentMessage->sender->name) : 'Pesan',
                    'body' => $parentMessage->body ?: ($parentMessage->attachment_name ?: 'Lampiran berkas'),
                ] : null,
                'time_formatted' => $msg->created_at ? $msg->created_at->format('H:i') : 'Baru saja',
                'sender_avatar' => $currentUser->avatar_url,
            ],
        ]);
    }

    /**
     * Toggle pinned status of a message.
     */
    public function togglePin(Request $request, $id): JsonResponse
    {
        $currentUser = Auth::user();
        $message = Message::visibleTo($currentUser->id)->findOrFail((int) $id);

        $newPinnedState = !$message->is_pinned;

        // If pinning, unpin other pinned messages in this conversation
        if ($newPinnedState) {
            Message::where('conversation_id', $message->conversation_id)
                ->where('is_pinned', true)
                ->update(['is_pinned' => false]);
        }

        $message->is_pinned = $newPinnedState;
        $message->save();

        return response()->json([
            'success' => true,
            'is_pinned' => $message->is_pinned,
            'message_id' => $message->id,
            'message' => $message->is_pinned ? 'Pesan berhasil disematkan di obrolan.' : 'Sematan pesan berhasil dilepas.',
        ]);
    }

    /**
     * Toggle reaction emoji on a message.
     */
    public function toggleReaction(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'emoji' => ['required', 'string', 'max:20'],
        ]);

        $currentUser = Auth::user();
        $message = Message::visibleTo($currentUser->id)->findOrFail((int) $id);

        $reactions = $message->toggleReaction($validated['emoji'], $currentUser->id);

        return response()->json([
            'success' => true,
            'message_id' => $message->id,
            'reactions' => $reactions,
            'message' => 'Reaksi pesan berhasil diperbarui.',
        ]);
    }

    /**
     * Forward an existing message to another user.
     */
    public function forward(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'target_user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $currentUser = Auth::user();
        $targetUser = User::findOrFail((int) $validated['target_user_id']);

        if ($targetUser->id === $currentUser->id) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat meneruskan pesan ke diri sendiri.'], 422);
        }

        $sourceMsg = Message::visibleTo($currentUser->id)->findOrFail((int) $id);
        $convId = Message::makeConversationId($currentUser->id, $targetUser->id);

        $newMsg = Message::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $targetUser->id,
            'conversation_id' => $convId,
            'body' => $sourceMsg->body,
            'attachment_url' => $sourceMsg->attachment_url,
            'attachment_name' => $sourceMsg->attachment_name,
            'attachment_type' => $sourceMsg->attachment_type,
            'attachment_size' => $sourceMsg->attachment_size,
            'message_type' => 'direct',
            'is_read' => false,
            'is_pinned' => false,
            'reactions' => null,
            'is_forwarded' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil diteruskan ke ' . $targetUser->name . '.',
            'target_user_id' => $targetUser->id,
        ]);
    }

    /**
     * Get clean display text for last message summary.
     */
    private function getDisplayLastMessage(?Message $msg): string
    {
        if (!$msg) {
            return 'Belum ada obrolan.';
        }

        if (!empty($msg->body)) {
            return $msg->body;
        }

        if ($msg->attachment_type === 'voice') {
            return '🎙️ [Pesan Suara]';
        }

        if ($msg->attachment_type === 'image' || in_array(strtolower(pathinfo($msg->attachment_url ?? '', PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            return '📷 [Foto / Gambar]';
        }

        if ($msg->attachment_name) {
            return '📎 [' . $msg->attachment_name . ']';
        }

        if ($msg->attachment_url) {
            return '📎 [Lampiran Berkas]';
        }

        return 'Belum ada obrolan.';
    }

    /**
     * Format bytes to readable size string.
     */
    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    /**
     * Delete a message.
     * - If deleted by sender: permanently delete for everyone (unsend).
     * - If deleted by receiver: delete only for receiver (keep visible to sender).
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $currentUser = Auth::user();
        $message = Message::findOrFail((int) $id);

        // Validasi otoritas: hanya pengirim atau penerima yang boleh menghapus
        if ($message->sender_id !== $currentUser->id && $message->receiver_id !== $currentUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki hak akses untuk menghapus pesan ini.',
            ], 403);
        }

        // KASUS 1: Dihapus oleh Pengirim (Sender) -> Hapus permanen untuk semua orang
        if ($message->sender_id === $currentUser->id) {
            // Hapus file lampiran dari disk penyimpanan jika ada
            if ($message->attachment_url) {
                $storagePrefix = asset('storage/');
                $relativeStoragePath = str_replace($storagePrefix . '/', '', $message->attachment_url);
                if (Storage::disk('public')->exists($relativeStoragePath)) {
                    Storage::disk('public')->delete($relativeStoragePath);
                }
            }

            $message->delete();

            return response()->json([
                'success' => true,
                'deleted_for_everyone' => true,
                'message' => 'Pesan berhasil ditarik dan dihapus untuk semua orang.',
            ]);
        }

        // KASUS 2: Dihapus oleh Penerima (Receiver) -> Sembunyikan hanya untuk penerima
        $message->update([
            'deleted_for_receiver' => true,
        ]);

        return response()->json([
            'success' => true,
            'deleted_for_everyone' => false,
            'message' => 'Pesan berhasil dihapus dari tampilan percakapan Anda.',
        ]);
    }

    /**
     * Clear entire conversation history with a target user for the current user.
     * Keeps all messages intact for the opponent.
     */
    public function clearConversation(Request $request, $user): JsonResponse
    {
        $currentUser = Auth::user();
        $targetUser = $user instanceof User ? $user : User::findOrFail((int) $user);

        $convId = Message::makeConversationId($currentUser->id, $targetUser->id);

        // Tandai pesan yang dikirim oleh current user sebagai terhapus untuk pengirim
        Message::where('conversation_id', $convId)
            ->where('sender_id', $currentUser->id)
            ->update([
                'deleted_for_sender' => true,
            ]);

        // Tandai pesan yang diterima oleh current user sebagai terhapus untuk penerima
        Message::where('conversation_id', $convId)
            ->where('receiver_id', $currentUser->id)
            ->update([
                'deleted_for_receiver' => true,
                'is_read' => true,
            ]);

        // Bersihkan data jika kedua belah pihak sudah menghapus pesan yang sama
        $bothDeleted = Message::where('conversation_id', $convId)
            ->where('deleted_for_sender', true)
            ->where('deleted_for_receiver', true)
            ->get();

        foreach ($bothDeleted as $bMsg) {
            if ($bMsg->attachment_url) {
                $storagePrefix = asset('storage/');
                $relativeStoragePath = str_replace($storagePrefix . '/', '', $bMsg->attachment_url);
                if (Storage::disk('public')->exists($relativeStoragePath)) {
                    Storage::disk('public')->delete($relativeStoragePath);
                }
            }
            $bMsg->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Seluruh riwayat obrolan dengan ' . $targetUser->name . ' berhasil dibersihkan dari tampilan Anda.',
        ]);
    }
}
