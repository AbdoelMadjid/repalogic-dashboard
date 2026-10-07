<?php

namespace App\Models\Admin\DukunganAplikasi;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Admin\DukunganAplikasi\FiturAplikasi
 *
 * @property int $id
 * @property string $kode_fitur
 * @property string $nama_fitur
 * @property string $kategori
 * @property string|null $deskripsi
 * @property string|null $icon
 * @property bool $status
 * @property int $urutan
 * @property bool $is_system
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereKodeFitur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereNamaFitur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereUrutan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereIsSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi select(...$columns)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi distinct()
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi findOrFail($id, $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi create(array $attributes = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereIn($column, $values)
 * @method static \Illuminate\Database\Eloquent\Builder|FiturAplikasi whereNotIn($column, $values)
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class FiturAplikasi extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fitur_aplikasi';

    protected $fillable = [
        'kode_fitur',
        'nama_fitur',
        'kategori',
        'deskripsi',
        'icon',
        'status',
        'urutan',
        'is_system',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_system' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Get cached feature settings map as a safe helper object.
     */
    public static function getSettings(): FeatureSettingMap
    {
        $features = Cache::rememberForever('fitur_aplikasi_raw_map', function () {
            try {
                return self::pluck('status', 'kode_fitur')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });

        return new FeatureSettingMap($features);
    }

    /**
     * Check if a specific feature is enabled.
     */
    public static function isActive(string $kodeFitur, bool $default = true): bool
    {
        $settings = self::getSettings();
        return $settings->isActive($kodeFitur, $default);
    }

    /**
     * Clear the cached feature settings.
     */
    public static function clearCache(): void
    {
        Cache::forget('fitur_aplikasi_raw_map');
        Cache::forget('fitur_aplikasi_settings_map');
        Cache::forget('fitur_aplikasi_settings');
    }
}
