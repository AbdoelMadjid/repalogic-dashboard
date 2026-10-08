<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable, LogsActivity;

    protected array $activityLogIgnore = [
        'last_login_at',
        'last_login_point_at',
        'login_count',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'status',
        'approved_at',
        'approved_by',
        'password_reset_requested_at',
        'deactivation_requested_at',
        'deactivation_reason',
        'reactivation_requested_at',
        'reactivation_reason',
        'rejection_reason',
        'login_count',
        'last_login_at',
        'last_login_point_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The accessors to append to the model's array and JSON form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'avatar_url',
        'role_name',
        'cover_bg_url',
        'cover_position_y',
        'cover_height',
        'cover_color',
        'cover_opacity',
        'cover_blur',
        'motto',
        'profile_completion_percentage',
        'is_online',
        'last_seen_human',
        'profile_likes_count',
        'friends_count',
        'two_factor_enabled',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'password_reset_requested_at' => 'datetime',
            'deactivation_requested_at' => 'datetime',
            'reactivation_requested_at' => 'datetime',
            'last_login_at' => 'datetime',
            'last_login_point_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'login_count' => 'integer',
            'password' => 'hashed',
        ];
    }

    /**
     * Determine if Two-Factor Authentication is fully confirmed and enabled.
     */
    public function hasEnabledTwoFactor(): bool
    {
        return !empty($this->two_factor_secret) && !is_null($this->two_factor_confirmed_at);
    }

    /**
     * Accessor for two_factor_enabled boolean attribute.
     */
    public function getTwoFactorEnabledAttribute(): bool
    {
        return $this->hasEnabledTwoFactor();
    }

    /**
     * Get decrypted recovery codes as an array.
     */
    public function recoveryCodes(): array
    {
        if (empty($this->two_factor_recovery_codes)) {
            return [];
        }

        try {
            return json_decode(decrypt($this->two_factor_recovery_codes), true) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Consume / replace used recovery code.
     */
    public function replaceRecoveryCode(string $code): bool
    {
        $codes = $this->recoveryCodes();

        $index = array_search(trim($code), $codes, true);
        if ($index === false) {
            return false;
        }

        unset($codes[$index]);
        $this->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode(array_values($codes))),
        ])->save();

        return true;
    }

    /**
     * Helper untuk mengubah teks berhuruf kapital semua (ALL CAPS) menjadi Title Case (huruf besar di awal kata).
     */
    public static function formatTitleCase(?string $text): string
    {
        if (empty($text)) {
            return '';
        }
        $trimmed = trim($text);
        // Jika berisi huruf alfabet dan seluruhnya huruf besar (ALL CAPS)
        if (preg_match('/[a-zA-Z]/', $trimmed) && $trimmed === mb_strtoupper($trimmed, 'UTF-8')) {
            return mb_convert_case(mb_strtolower($trimmed, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
        }
        return $trimmed;
    }

    /**
     * Mutator & accessor untuk atribut name.
     * Otomatis mengonversi nama berhuruf besar semua menjadi huruf besar di awal kata saat disimpan ke database.
     */
    protected function name(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            set: fn ($value) => self::formatTitleCase($value)
        );
    }

    /**
     * Check if user has an active password reset request.
     */
    public function isPasswordResetRequested(): bool
    {
        return !is_null($this->password_reset_requested_at);
    }

    /**
     * Check if user has an active deactivation request.
     */
    public function isDeactivationRequested(): bool
    {
        return !is_null($this->deactivation_requested_at);
    }

    /**
     * Check if user has an active reactivation request.
     */
    public function isReactivationRequested(): bool
    {
        return !is_null($this->reactivation_requested_at);
    }

    /**
     * Check if user is in pending approval state.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Relationship to Message model (Received messages).
     */
    public function receivedMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Relationship to Message model (Sent messages).
     */
    public function sentMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Relationship to UserMediaHistory model (Avatar and Cover changes).
     */
    public function mediaHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserMediaHistory::class, 'user_id');
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is inactive / suspended.
     */
    public function isInactive(): bool
    {
        return $this->status === 'inactive';
    }

    /**
     * Check if user registration was rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Get the admin user who approved this account.
     */
    public function approver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get full avatar URL or default image fallback.
     */
    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->avatar)) {
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }

            $path = ltrim($this->avatar, '/');

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

        return asset('assets/images/users/user-default.jpg');
    }

    /**
     * Get avatar visual offset position (e.g. "50% 20%") derived from crop data.
     */
    public function getAvatarPositionAttribute(): string
    {
        $cropData = $this->config?->settings['avatar_crop_data'] ?? null;
        if (!empty($cropData) && isset($cropData['posX']) && isset($cropData['posY'])) {
            return "{$cropData['posX']}% {$cropData['posY']}%";
        }

        return 'center top';
    }

    /**
     * Get uncropped master avatar URL (for re-cropping from full photo), or fallback to avatar URL.
     */
    public function getAvatarOriginalUrlAttribute(): ?string
    {
        $origPath = $this->config?->settings['avatar_original'] ?? null;
        if (!empty($origPath)) {
            if (filter_var($origPath, FILTER_VALIDATE_URL)) {
                return $origPath;
            }
            $path = ltrim($origPath, '/');
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

        return !empty($this->avatar) ? $this->avatar_url : null;
    }

    /**
     * Get avatar cropping configuration coordinates & scale data.
     */
    public function getAvatarCropDataAttribute(): ?array
    {
        return $this->config?->settings['avatar_crop_data'] ?? null;
    }

    /**
     * Get primary role name capitalized.
     */
    public function getRoleNameAttribute(): string
    {
        $role = $this->roles->first()?->name;
        return $role ? ucfirst($role) : 'User';
    }

    /**
     * Get the user detail record (KTP & address info).
     */
    public function detail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /**
     * Get the user configuration record (Theme & Cover background).
     */
    public function config(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserConfig::class, 'user_id');
    }

    /**
     * Get default cover photo URL from stock assets (deterministic random per identifier or fallback).
     */
    public static function getDefaultCoverUrl(int|string|null $identifier = null): string
    {
        $stockImages = [
            'assets/images/stock/small-1.jpg',
            'assets/images/stock/small-2.jpg',
            'assets/images/stock/small-3.jpg',
            'assets/images/stock/small-4.jpg',
            'assets/images/stock/small-5.jpg',
            'assets/images/stock/small-6.jpg',
            'assets/images/stock/small-7.jpg',
            'assets/images/stock/small-8.jpg',
            'assets/images/stock/small-9.jpg',
            'assets/images/stock/small-10.jpg',
        ];

        if ($identifier !== null && $identifier !== '') {
            $num = is_numeric($identifier) ? (int) $identifier : crc32((string) $identifier);
            $index = abs($num) % count($stockImages);
            return asset($stockImages[$index]);
        }

        return asset('assets/images/profile-bg.jpg');
    }

    /**
     * Accessor for user cover background banner URL.
     */
    public function getCoverBgUrlAttribute(): string
    {
        if ($this->config && !empty($this->config->cover_bg_url)) {
            return $this->config->cover_bg_url;
        }

        return self::getDefaultCoverUrl($this->id ?? $this->email);
    }

    /**
     * Accessor for cover background vertical offset percentage (0 to 100).
     */
    public function getCoverPositionYAttribute(): int
    {
        return (int) ($this->config?->cover_position_y ?? 50);
    }

    /**
     * Accessor for user cover background banner height in pixels (default: 320px).
     */
    public function getCoverHeightAttribute(): int
    {
        return (int) ($this->config?->cover_height ?: 320);
    }

    /**
     * Accessor for user cover overlay color (default: #313a46).
     */
    public function getCoverColorAttribute(): string
    {
        return $this->config?->cover_color ?: '#313a46';
    }

    /**
     * Accessor for user cover overlay opacity percentage (default: 60%).
     */
    public function getCoverOpacityAttribute(): int
    {
        return isset($this->config?->cover_opacity) ? (int) $this->config->cover_opacity : 60;
    }

    /**
     * Accessor for user cover overlay blur level in pixels (default: 0px).
     */
    public function getCoverBlurAttribute(): int
    {
        return isset($this->config?->cover_blur) ? (int) $this->config->cover_blur : 0;
    }

    /**
     * Curated list of inspiring default life mottos.
     */
    public static array $defaultMottos = [
        'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.',
        'Jadikan setiap langkah sebagai jejak kebaikan dan inspirasi.',
        'Kerja keras mengalahkan bakat ketika bakat tidak bekerja keras.',
        'Kesuksesan berawal dari keberanian untuk memulai hal kecil dengan konsisten.',
        'Fokus pada proses, nikmati setiap pembelajaran dalam perjalanan hidup.',
        'Disiplin adalah jembatan antara impian dan pencapaian nyata.',
        'Berpikir positif, bertindak bijak, dan selalu bersyukur atas setiap proses.',
        'Inovasi membedakan antara seorang pemimpin dan pengikut sejati.',
        'Kebaikan kecil yang konsisten lebih berharga dari rencana besar tanpa aksi.',
        'Bekerja dengan integritas, berkarya dengan dedikasi dan ketulusan hati.',
        'Jangan takut gagal, takutlah jika kesempatan berlalu tanpa pernah mencoba.',
        'Waktu terbaik untuk memulai langkah besar adalah hari ini.',
        'Bekerja cerdas, bersikap rendah hati, dan terus melangkah maju.',
        'Tantangan hari ini adalah kekuatan untuk meraih kesuksesan esok hari.',
        'Jadilah agen perubahan positif di mana pun Anda berada.',
        'Kunci kesuksesan sejati adalah mencintai apa yang sedang Anda kerjakan.',
        'Selalu ada jalan terbuka bagi mereka yang memiliki tekad pantang menyerah.',
        'Kesabaran dan ketekunan mampu meluluhkan segala rintangan besar.',
        'Mimpi besar tidak akan pernah terwujud tanpa tindakan nyata dan konsisten.',
        'Hidup adalah perjalanan belajar dan bertumbuh yang tidak pernah berhenti.'
    ];

    /**
     * Accessor for user profile motto quote.
     */
    public function getMottoAttribute(): string
    {
        if (!empty($this->config?->motto)) {
            return $this->config->motto;
        }

        $mottos = self::$defaultMottos;
        $index = abs(crc32((string) ($this->id ?? 1))) % count($mottos);
        return $mottos[$index];
    }

    /**
     * Accessor for user profile motto text color (default: #ffffff).
     */
    public function getMottoColorAttribute(): string
    {
        return $this->config?->motto_color ?: '#ffffff';
    }

    /**
     * Calculate user profile completion percentage (0 to 100).
     */
    public function getProfileCompletionPercentageAttribute(): int
    {
        $score = 0;

        // 1. Avatar (10%)
        if (!empty($this->avatar)) {
            $score += 10;
        }

        // 2. Cover image (10%)
        if ($this->config && !empty($this->config->cover_image)) {
            $score += 10;
        }

        // 3. Motto (10%)
        if ($this->config && !empty($this->config->motto)) {
            $score += 10;
        }

        $detail = $this->detail;
        if ($detail) {
            // 4. NIK (15%)
            if (!empty($detail->nik)) {
                $score += 15;
            }
            // 5. Nama KTP (10%)
            if (!empty($detail->nama_ktp)) {
                $score += 10;
            }
            // 6. Tempat & Tanggal Lahir (10%)
            if (!empty($detail->tempat_lahir) && !empty($detail->tanggal_lahir)) {
                $score += 10;
            }
            // 7. Jenis Kelamin & Agama (10%)
            if (!empty($detail->jenis_kelamin) && !empty($detail->agama)) {
                $score += 10;
            }
            // 8. Alamat Jalan, RT, RW (15%)
            if (!empty($detail->alamat_jalan) || !empty($detail->rt)) {
                $score += 15;
            }
            // 9. Kec, Kota, Prov (10%)
            if (!empty($detail->kecamatan) && !empty($detail->kabupaten_kota)) {
                $score += 10;
            }
        }

        return min(100, $score);
    }

    /**
     * Relasi ke seluruh riwayat login pengguna.
     */
    public function logins(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Admin\ManajemenPengguna\UserLogin::class, 'user_id');
    }

    /**
     * Relasi ke entri login terbaru.
     */
    public function latestLogin(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\Admin\ManajemenPengguna\UserLogin::class, 'user_id')->latestOfMany('login_at');
    }

    /**
     * Catat aktivitas login dan hitung poin login (1 poin per 24 jam / hari).
     */
    public function recordLogin(\Illuminate\Http\Request $request): \App\Models\Admin\ManajemenPengguna\UserLogin
    {
        $now = \Carbon\Carbon::now();
        $awardPoint = false;

        // Aturan poin: bertambah 1 jika belum pernah dapat poin ATAU sudah >= 24 jam ATAU tanggal berbeda
        if ($this->last_login_point_at === null) {
            $awardPoint = true;
        } elseif ($this->last_login_point_at->diffInHours($now) >= 24 || ! $this->last_login_point_at->isSameDay($now)) {
            $awardPoint = true;
        }

        if ($awardPoint) {
            $this->login_count = ($this->login_count ?? 0) + 1;
            $this->last_login_point_at = $now;
        }

        $this->last_login_at = $now;
        $this->save();

        return \App\Models\Admin\ManajemenPengguna\UserLogin::record($this, $request, $awardPoint);
    }

    /**
     * Cek apakah pengguna saat ini sedang online (berdasarkan cache TTL).
     */
    public function getIsOnlineAttribute(): bool
    {
        return \Illuminate\Support\Facades\Cache::has('user-online-' . $this->id);
    }

    /**
     * Waktu aktivitas terakhir pengguna (Carbon).
     */
    public function getLastSeenTimeAttribute(): ?\Carbon\Carbon
    {
        $lastSeenIso = \Illuminate\Support\Facades\Cache::get('user-last-seen-' . $this->id);
        if ($lastSeenIso) {
            return \Carbon\Carbon::parse($lastSeenIso);
        }

        return $this->last_login_at;
    }

    /**
     * Teks waktu aktif terakhir yang mudah dipahami manusia.
     */
    public function getLastSeenHumanAttribute(): string
    {
        if ($this->is_online) {
            return 'Online Sekarang';
        }

        $lastSeen = $this->last_seen_time;
        if ($lastSeen) {
            return 'Aktif ' . $lastSeen->diffForHumans();
        }

        return 'Offline';
    }

    /**
     * Render badge HTML status kehadiran online/offline.
     */
    public function getOnlineStatusBadgeAttribute(): string
    {
        if ($this->is_online) {
            return '<span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1.5"><span class="badge-pulse-dot bg-success"></span>Online</span>';
        }

        $lastSeen = $this->last_seen_time;
        $timeText = $lastSeen ? $lastSeen->diffForHumans() : 'Offline';

        return '<span class="badge bg-secondary-subtle text-muted border border-secondary-subtle d-inline-flex align-items-center gap-1.5"><span class="badge-dot-gray"></span>' . e($timeText) . '</span>';
    }

    /**
     * Relationship to ProfileLike model (Likes given to other users).
     */
    public function profileLikesGiven(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProfileLike::class, 'user_id');
    }

    /**
     * Relationship to ProfileLike model (Likes received on this user's profile).
     */
    public function profileLikesReceived(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProfileLike::class, 'target_user_id');
    }

    /**
     * Get total profile likes received.
     */
    public function getProfileLikesCountAttribute(): int
    {
        if ($this->relationLoaded('profileLikesReceived')) {
            return $this->profileLikesReceived->count();
        }

        return $this->profileLikesReceived()->count();
    }

    /**
     * Check if this user's profile is liked by a specific user.
     */
    public function isLikedBy($user): bool
    {
        $userId = $user instanceof User ? $user->id : (int) $user;

        if ($this->relationLoaded('profileLikesReceived')) {
            return $this->profileLikesReceived->contains('user_id', $userId);
        }

        return $this->profileLikesReceived()->where('user_id', $userId)->exists();
    }

    /**
     * Relationship to Friendship model (Sent friend requests).
     */
    public function sentFriendships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Friendship::class, 'sender_id');
    }

    /**
     * Relationship to Friendship model (Received friend requests).
     */
    public function receivedFriendships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Friendship::class, 'receiver_id');
    }

    /**
     * Get all accepted friendships (either as sender or receiver).
     */
    public function getFriendsCountAttribute(): int
    {
        $sentCount = $this->relationLoaded('sentFriendships')
            ? $this->sentFriendships->where('status', 'accepted')->count()
            : $this->sentFriendships()->accepted()->count();

        $receivedCount = $this->relationLoaded('receivedFriendships')
            ? $this->receivedFriendships->where('status', 'accepted')->count()
            : $this->receivedFriendships()->accepted()->count();

        return $sentCount + $receivedCount;
    }

    /**
     * Get detailed friendship relationship with a specific user.
     * Returns array with 'status' (self, friends, pending_sent, pending_received, none) and 'friendship' model if exists.
     */
    public function getFriendshipWith($targetUser): array
    {
        $targetId = $targetUser instanceof User ? $targetUser->id : (int) $targetUser;

        if ($this->id === $targetId) {
            return ['status' => 'self', 'friendship' => null];
        }

        // Check if sent by current user
        $sentFriendship = $this->relationLoaded('sentFriendships')
            ? $this->sentFriendships->firstWhere('receiver_id', $targetId)
            : $this->sentFriendships()->where('receiver_id', $targetId)->first();

        if ($sentFriendship) {
            if ($sentFriendship->status === 'accepted') {
                return ['status' => 'friends', 'friendship' => $sentFriendship];
            } elseif ($sentFriendship->status === 'pending') {
                return ['status' => 'pending_sent', 'friendship' => $sentFriendship];
            }
        }

        // Check if received by current user
        $receivedFriendship = $this->relationLoaded('receivedFriendships')
            ? $this->receivedFriendships->firstWhere('sender_id', $targetId)
            : $this->receivedFriendships()->where('sender_id', $targetId)->first();

        if ($receivedFriendship) {
            if ($receivedFriendship->status === 'accepted') {
                return ['status' => 'friends', 'friendship' => $receivedFriendship];
            } elseif ($receivedFriendship->status === 'pending') {
                return ['status' => 'pending_received', 'friendship' => $receivedFriendship];
            }
        }

        return ['status' => 'none', 'friendship' => null];
    }

    /**
     * Hitung total seluruh pengguna yang sedang online saat ini.
     */
    public static function getOnlineUsersCount(): int
    {
        $count = 0;
        $activeUserIds = static::where('status', 'active')->pluck('id');
        foreach ($activeUserIds as $id) {
            if (\Illuminate\Support\Facades\Cache::has('user-online-' . $id)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get user setting value with dot notation and default fallback.
     */
    public function getSetting(string $key, mixed $default = null): mixed
    {
        $settings = $this->config?->settings ?? [];
        return data_get($settings, $key, $default);
    }

    /**
     * Set user setting value with dot notation and save.
     */
    public function setSetting(string $key, mixed $value): void
    {
        $config = $this->config ?? \App\Models\UserConfig::firstOrNew(['user_id' => $this->id]);
        $settings = $config->settings ?? [];
        data_set($settings, $key, $value);
        $config->settings = $settings;
        $config->save();
    }

    /**
     * Get all user settings merged with default configuration.
     */
    public function getAllSettings(): array
    {
        $defaults = [
            'chat' => [
                'who_can_message' => 'everyone', // everyone, friends, none
                'read_receipts' => true,
                'online_status_visibility' => 'everyone', // everyone, friends, hide
                'sound_alert' => 'pop', // default, pop, ding, mute
                'send_on_enter' => true,
            ],
            'lock_screen' => [
                'auto_lock_timeout' => 15, // 0 (disabled), 5, 15, 30, 60
            ],
            'appearance' => [
                'theme_mode' => 'system', // light, dark, system
                'sidebar_style' => 'default', // default, compact, icon
                'table_density' => 'normal', // normal, compact
                'reduce_motion' => false,
            ],
            'notifications' => [
                'browser_push' => true,
                'sound_chime' => true,
                'events' => [
                    'friend_request' => true,
                    'profile_like' => true,
                    'chat_message' => true,
                    'security_alert' => true,
                    'global_announcement' => true,
                ],
            ],
            'privacy' => [
                'profile_visibility' => 'public', // public, friends, private
                'allow_likes' => true,
                'show_points' => true,
                'allow_friend_requests' => 'everyone', // everyone, friends_of_friends, none
            ],
            'localization' => [
                'locale' => 'id', // id, en
                'timezone' => 'Asia/Jakarta', // Asia/Jakarta, Asia/Makassar, Asia/Jayapura, UTC
                'date_format' => 'DD/MM/YYYY',
            ],
        ];

        $saved = $this->config?->settings ?? [];
        return array_replace_recursive($defaults, is_array($saved) ? $saved : []);
    }
}


