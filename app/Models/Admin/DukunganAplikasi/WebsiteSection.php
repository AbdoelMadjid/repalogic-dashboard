<?php

namespace App\Models\Admin\DukunganAplikasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSection extends Model
{
    use HasFactory;

    protected $table = 'website_sections';

    protected $fillable = [
        'website_theme_id',
        'section_name',
        'section_key',
        'section_file',
        'nav_title',
        'target_id',
        'show_in_nav',
        'is_active',
        'orders',
        'bg_type',
        'bg_color_class',
        'bg_image',
        'bg_position_y',
        'bg_size',
        'bg_attachment',
        'bg_image_width',
        'bg_image_height',
        'bg_image_orientation',
    ];

    protected $casts = [
        'show_in_nav' => 'boolean',
        'is_active' => 'boolean',
        'orders' => 'integer',
        'bg_position_y' => 'integer',
        'bg_image_width' => 'integer',
        'bg_image_height' => 'integer',
    ];

    /**
     * Relasi ke Tema Website.
     */
    public function theme()
    {
        return $this->belongsTo(WebsiteTheme::class, 'website_theme_id');
    }

    /**
     * Booted lifecycle hook to clear active theme cache when section changes.
     */
    protected static function booted()
    {
        static::saved(function () {
            WebsiteTheme::clearCache();
        });
        static::deleted(function () {
            WebsiteTheme::clearCache();
        });
    }
}
