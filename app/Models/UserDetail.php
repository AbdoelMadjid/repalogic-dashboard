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

    /**
     * Get the user that owns the detail.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
}
