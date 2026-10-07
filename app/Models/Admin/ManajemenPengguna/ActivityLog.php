<?php

namespace App\Models\Admin\ManajemenPengguna;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'event',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Polymorphic relation to the subject model that was altered.
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Polymorphic relation to the causer (actor/user) who performed the action.
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Convenience method to manually record an activity log entry.
     */
    public static function log(
        string $description,
        mixed $subject = null,
        string $event = 'custom',
        array $properties = [],
        ?string $logName = null,
        ?User $causer = null
    ): self {
        $actor = $causer ?: Auth::user();

        $subjectType = null;
        $subjectId = null;

        if ($subject instanceof Model) {
            $subjectType = get_class($subject);
            $subjectId = $subject->getKey();
            if (!$logName) {
                $logName = strtolower(class_basename($subject));
            }
        } elseif (is_string($subject)) {
            $subjectType = $subject;
        }

        return self::create([
            'log_name' => $logName ?: 'default',
            'description' => $description,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'event' => $event,
            'causer_type' => $actor ? get_class($actor) : null,
            'causer_id' => $actor ? $actor->getKey() : null,
            'properties' => !empty($properties) ? $properties : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Get badge color class for event.
     */
    public function getEventBadgeClassAttribute(): string
    {
        return match ($this->event) {
            'created' => 'bg-success-subtle text-success border border-success-subtle',
            'updated' => 'bg-warning-subtle text-warning border border-warning-subtle',
            'deleted' => 'bg-danger-subtle text-danger border border-danger-subtle',
            'restored' => 'bg-info-subtle text-info border border-info-subtle',
            'login', 'auth' => 'bg-primary-subtle text-primary border border-primary-subtle',
            default => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
        };
    }

    /**
     * Get icon for event.
     */
    public function getEventIconAttribute(): string
    {
        return match ($this->event) {
            'created' => 'ti ti-plus',
            'updated' => 'ti ti-edit',
            'deleted' => 'ti ti-trash',
            'restored' => 'ti ti-rotate-clockwise',
            'login', 'auth' => 'ti ti-login',
            default => 'ti ti-activity',
        };
    }

    /**
     * Get formatted readable module/log name.
     */
    public function getLogNameLabelAttribute(): string
    {
        return match ($this->log_name) {
            'user' => 'Pengguna (User)',
            'role' => 'Peran (Role)',
            'permission' => 'Izin Akses (Permission)',
            'menu' => 'Navigasi Menu',
            'setting', 'app_setting' => 'Pengaturan Sistem',
            'profil_aplikasi' => 'Profil Aplikasi',
            'backup' => 'Backup Database',
            default => ucfirst($this->log_name),
        };
    }
}
