<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'nik',
        'telepon',
        'nama_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'alamat_jalan',
        'rt',
        'rw',
        'blok',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'foto_ktp',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected $appends = [
        'alamat_lengkap',
        'cover_bg_url',
        'foto_ktp_url',
        'telepon_wa_url',
    ];

    /**
     * Get the user that owns the detail.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor for WhatsApp click URL.
     */
    public function getTeleponWaUrlAttribute(): ?string
    {
        if (empty($this->telepon)) {
            return null;
        }

        $cleaned = preg_replace('/[^0-9]/', '', $this->telepon);
        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62' . substr($cleaned, 1);
        } elseif (str_starts_with($cleaned, '8')) {
            $cleaned = '62' . $cleaned;
        }

        return 'https://wa.me/' . $cleaned;
    }

    /**
     * Accessor for foto KTP URL.
     */
    public function getFotoKtpUrlAttribute(): ?string
    {
        if (!empty($this->foto_ktp)) {
            $path = ltrim($this->foto_ktp, '/');
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

        return null;
    }

    /**
     * Accessor for full address string formatted.
     */
    public function getAlamatLengkapAttribute(): string
    {
        $parts = [];
        if (!empty($this->alamat_jalan)) $parts[] = $this->alamat_jalan;
        if (!empty($this->blok)) $parts[] = 'Blok ' . $this->blok;
        if (!empty($this->rt) || !empty($this->rw)) $parts[] = 'RT ' . ($this->rt ?? '-') . ' / RW ' . ($this->rw ?? '-');
        if (!empty($this->desa_kelurahan)) $parts[] = 'Desa/Kel. ' . $this->desa_kelurahan;
        if (!empty($this->kecamatan)) $parts[] = 'Kec. ' . $this->kecamatan;
        if (!empty($this->kabupaten_kota)) $parts[] = $this->kabupaten_kota;
        if (!empty($this->provinsi)) $parts[] = $this->provinsi;
        if (!empty($this->kode_pos)) $parts[] = $this->kode_pos;

        return !empty($parts) ? implode(', ', $parts) : 'Belum diisi';
    }

    /**
     * Accessor for profile cover background banner image URL.
     */
    public function getCoverBgUrlAttribute(): string
    {
        if (!empty($this->foto_ktp)) {
            $path = ltrim($this->foto_ktp, '/');
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
