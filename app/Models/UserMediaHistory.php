<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UserMediaHistory extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'user_media_histories';

    protected $fillable = [
        'user_id',
        'media_type',
        'file_path',
        'file_name',
        'description',
        'meta_data',
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];

    /**
     * Relationship to the User model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor for full media URL with safe fallback.
     */
    public function getUrlAttribute(): ?string
    {
        if (empty($this->file_path)) {
            return null;
        }

        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }

        if (str_starts_with($this->file_path, 'assets/')) {
            return asset($this->file_path);
        }

        if (Storage::disk('public')->exists($this->file_path)) {
            return Storage::disk('public')->url($this->file_path);
        }

        return null;
    }
}
