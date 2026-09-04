<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserConfig extends Model
{
    use HasFactory;

    protected $table = 'user_configs';

    protected $fillable = [
        'user_id',
        'cover_image',
        'cover_position_y',
        'cover_height',
        'cover_color',
        'cover_opacity',
        'cover_blur',
        'motto',
        'motto_color',
        'theme_mode',
        'settings',
    ];

    protected $casts = [
        'cover_position_y' => 'integer',
        'cover_height' => 'integer',
        'cover_opacity' => 'integer',
        'cover_blur' => 'integer',
        'settings' => 'array',
    ];

    protected $appends = [
        'cover_bg_url',
    ];

    /**
     * Get the user that owns the configuration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor for full cover image URL or default background fallback.
     */
    public function getCoverBgUrlAttribute(): string
    {
        if (!empty($this->cover_image)) {
            if (filter_var($this->cover_image, FILTER_VALIDATE_URL)) {
                return $this->cover_image;
            }

            $path = ltrim($this->cover_image, '/');

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                return asset('storage/' . $path);
            }
            if (file_exists(public_path('storage/' . $path))) {
                return asset('storage/' . $path);
            }
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return asset('assets/images/profile-bg.jpg');
    }
}
