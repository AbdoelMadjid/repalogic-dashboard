<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];

    /**
     * User who sent the friend request.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * User who received the friend request.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Scope for pending friendships.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for accepted friendships.
     */
    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope for rejected friendships.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }
}
