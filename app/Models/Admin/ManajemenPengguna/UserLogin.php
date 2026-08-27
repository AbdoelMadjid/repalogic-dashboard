<?php

namespace App\Models\Admin\ManajemenPengguna;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class UserLogin extends Model
{
    use HasFactory;

    protected $table = 'user_logins';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'device_type',
        'latitude',
        'longitude',
        'points_awarded',
        'login_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'points_awarded' => 'integer',
            'login_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope untuk filter login hari ini.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('login_at', Carbon::today());
    }

    /**
     * Scope untuk filter 7 hari terakhir.
     */
    public function scopeLast7Days($query)
    {
        return $query->where('login_at', '>=', Carbon::now()->subDays(7)->startOfDay());
    }

    /**
     * Scope untuk filter bulan ini.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereYear('login_at', Carbon::now()->year)
            ->whereMonth('login_at', Carbon::now()->month);
    }

    /**
     * Scope untuk pencarian berdasarkan nama, email user, ip_address, atau browser.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (empty($term)) {
            return $query;
        }

        $term = trim($term);

        return $query->where(function ($q) use ($term) {
            $q->where('ip_address', 'like', "%{$term}%")
                ->orWhere('browser', 'like', "%{$term}%")
                ->orWhere('platform', 'like', "%{$term}%")
                ->orWhere('device_type', 'like', "%{$term}%")
                ->orWhereHas('user', function ($uq) use ($term) {
                    $uq->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });
        });
    }

    /**
     * Helper statis untuk membuat riwayat login baru dari Request.
     */
    public static function record(User $user, Request $request, bool $pointsAwarded = false): self
    {
        $userAgent = $request->userAgent() ?? '';
        $clientInfo = self::parseUserAgent($userAgent);

        $lat = $request->filled('latitude') ? (float) $request->input('latitude') : null;
        $lng = $request->filled('longitude') ? (float) $request->input('longitude') : null;

        // Validasi range koordinat latitude [-90, 90] & longitude [-180, 180]
        if ($lat !== null && ($lat < -90 || $lat > 90)) {
            $lat = null;
        }
        if ($lng !== null && ($lng < -180 || $lng > 180)) {
            $lng = null;
        }

        return self::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'browser' => $clientInfo['browser'],
            'platform' => $clientInfo['platform'],
            'device_type' => $clientInfo['device_type'],
            'latitude' => $lat,
            'longitude' => $lng,
            'points_awarded' => $pointsAwarded ? 1 : 0,
            'login_at' => Carbon::now(),
        ]);
    }

    /**
     * Parser cerdas untuk mengekstrak nama browser, sistem operasi / platform, dan tipe perangkat.
     */
    public static function parseUserAgent(?string $userAgent): array
    {
        if (empty($userAgent)) {
            return [
                'browser' => 'Unknown',
                'platform' => 'Unknown',
                'device_type' => 'Desktop',
            ];
        }

        $browser = 'Unknown Browser';
        $platform = 'Unknown OS';
        $deviceType = 'Desktop';

        // 1. Deteksi Platform / OS
        if (preg_match('/windows nt 10/i', $userAgent)) {
            $platform = 'Windows 10/11';
        } elseif (preg_match('/windows nt 6\.3/i', $userAgent)) {
            $platform = 'Windows 8.1';
        } elseif (preg_match('/windows nt 6\.2/i', $userAgent)) {
            $platform = 'Windows 8';
        } elseif (preg_match('/windows nt 6\.1/i', $userAgent)) {
            $platform = 'Windows 7';
        } elseif (preg_match('/windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/iphone/i', $userAgent)) {
            $platform = 'iOS (iPhone)';
            $deviceType = 'Mobile';
        } elseif (preg_match('/ipad/i', $userAgent)) {
            $platform = 'iPadOS';
            $deviceType = 'Tablet';
        } elseif (preg_match('/android/i', $userAgent)) {
            $platform = 'Android';
            $deviceType = 'Mobile';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $platform = 'Linux';
        }

        // 2. Deteksi Browser
        if (preg_match('/edg(?:e|ios|a)?\/([0-9\.]+)/i', $userAgent, $matches)) {
            $browser = 'Microsoft Edge ' . explode('.', $matches[1])[0];
        } elseif (preg_match('/opr\/([0-9\.]+)|opera\/([0-9\.]+)/i', $userAgent, $matches)) {
            $ver = !empty($matches[1]) ? $matches[1] : $matches[2];
            $browser = 'Opera ' . explode('.', $ver)[0];
        } elseif (preg_match('/chrome\/([0-9\.]+)/i', $userAgent, $matches) && !preg_match('/edg/i', $userAgent)) {
            $browser = 'Google Chrome ' . explode('.', $matches[1])[0];
        } elseif (preg_match('/firefox\/([0-9\.]+)/i', $userAgent, $matches)) {
            $browser = 'Mozilla Firefox ' . explode('.', $matches[1])[0];
        } elseif (preg_match('/version\/([0-9\.]+).*safari/i', $userAgent, $matches)) {
            $browser = 'Apple Safari ' . explode('.', $matches[1])[0];
        } elseif (preg_match('/safari\/([0-9\.]+)/i', $userAgent, $matches)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/postman/i', $userAgent)) {
            $browser = 'Postman Runtime';
            $deviceType = 'API Client';
        }

        // 3. Deteksi Device Type tambahan
        if (preg_match('/mobile|android|iphone|ipod|blackberry|opera mini|iemobile/i', $userAgent)) {
            $deviceType = 'Mobile';
        } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
            $deviceType = 'Tablet';
        }

        return [
            'browser' => $browser,
            'platform' => $platform,
            'device_type' => $deviceType,
        ];
    }

    /**
     * Accessor untuk Google Maps URL jika ada koordinat.
     */
    public function getMapUrlAttribute(): ?string
    {
        if ($this->latitude !== null && $this->longitude !== null) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }

        return null;
    }

    /**
     * Accessor untuk OpenStreetMap Embed URL jika ada koordinat.
     */
    public function getOsmEmbedUrlAttribute(): ?string
    {
        if ($this->latitude !== null && $this->longitude !== null) {
            $lat = $this->latitude;
            $lng = $this->longitude;
            $delta = 0.01;
            $bbox = ($lng - $delta) . '%2C' . ($lat - $delta) . '%2C' . ($lng + $delta) . '%2C' . ($lat + $delta);
            return "https://www.openstreetmap.org/export/embed.html?bbox={$bbox}&layer=mapnik&marker={$lat}%2C{$lng}";
        }

        return null;
    }
}
