<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'conversation_id',
        'parent_id',
        'subject',
        'body',
        'reason',
        'message_type',
        'is_read',
        'read_at',
        'attachment_url',
        'attachment_name',
        'attachment_type',
        'attachment_size',
        'deleted_for_sender',
        'deleted_for_receiver',
        'is_pinned',
        'reactions',
        'is_forwarded',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'deleted_for_sender' => 'boolean',
        'deleted_for_receiver' => 'boolean',
        'is_pinned' => 'boolean',
        'reactions' => 'array',
        'is_forwarded' => 'boolean',
    ];

    /**
     * Toggle reaction emoji for a specific user ID.
     */
    public function toggleReaction(string $emoji, int $userId): array
    {
        $reactions = is_array($this->reactions) ? $this->reactions : [];
        
        $userList = isset($reactions[$emoji]) && is_array($reactions[$emoji]) ? $reactions[$emoji] : [];
        
        if (in_array($userId, $userList)) {
            // Remove user from reaction
            $userList = array_values(array_diff($userList, [$userId]));
            if (empty($userList)) {
                unset($reactions[$emoji]);
            } else {
                $reactions[$emoji] = $userList;
            }
        } else {
            // Add user to reaction
            $userList[] = $userId;
            $reactions[$emoji] = array_values(array_unique($userList));
        }

        $this->reactions = empty($reactions) ? null : $reactions;
        $this->save();

        return $this->reactions ?: [];
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function scopeForReceiver($query, int $userId)
    {
        return $query->where('receiver_id', $userId);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByConversation($query, string $conversationId)
    {
        return $query->where('conversation_id', $conversationId);
    }

    public function scopeVisibleTo($query, int $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where(function ($q1) use ($userId) {
                $q1->where('sender_id', $userId)
                   ->where('deleted_for_sender', false);
            })->orWhere(function ($q2) use ($userId) {
                $q2->where('receiver_id', $userId)
                   ->where('deleted_for_receiver', false);
            });
        });
    }

    /**
     * Generate a deterministic conversation ID for two user IDs.
     */
    public static function makeConversationId(int $userA, int $userB): string
    {
        $min = min($userA, $userB);
        $max = max($userA, $userB);

        return "conv_{$min}_{$max}";
    }
}
