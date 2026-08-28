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
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

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
