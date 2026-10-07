<?php

namespace App\Traits;

use App\Models\Admin\ManajemenPengguna\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot the trait and register Eloquent event listeners.
     */
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            $model->recordActivityLog('created');
        });

        static::updated(function (Model $model) {
            $model->recordActivityLog('updated');
        });

        static::deleted(function (Model $model) {
            $model->recordActivityLog('deleted');
        });
    }

    /**
     * Record an activity log entry for the given Eloquent event.
     */
    public function recordActivityLog(string $event): void
    {
        $logName = property_exists($this, 'activityLogName')
            ? $this->activityLogName
            : strtolower(class_basename($this));

        $ignoredAttributes = array_merge([
            'password',
            'remember_token',
            'two_factor_secret',
            'two_factor_recovery_codes',
            'updated_at',
            'created_at',
        ], property_exists($this, 'activityLogIgnore') ? $this->activityLogIgnore : []);

        $identifier = $this->resolveActivityIdentifier();
        $modelName = class_basename($this);
        $description = '';
        $properties = [];

        if ($event === 'created') {
            $attributes = collect($this->attributesToArray())
                ->except($ignoredAttributes)
                ->all();

            $description = "Menambahkan {$modelName} baru \"{$identifier}\"";
            $properties = [
                'attributes' => $attributes,
            ];
        } elseif ($event === 'updated') {
            $dirty = collect($this->getDirty())->except($ignoredAttributes);
            if ($dirty->isEmpty()) {
                return; // Nothing meaningful changed
            }

            $old = [];
            $attributes = [];

            foreach ($dirty as $key => $newValue) {
                $old[$key] = $this->getOriginal($key);
                $attributes[$key] = $newValue;
            }

            $changedFields = implode(', ', array_keys($attributes));
            $description = "Memperbarui data {$modelName} \"{$identifier}\" (Bidang: {$changedFields})";
            $properties = [
                'old' => $old,
                'attributes' => $attributes,
            ];
        } elseif ($event === 'deleted') {
            $old = collect($this->attributesToArray())
                ->except($ignoredAttributes)
                ->all();

            $description = "Menghapus {$modelName} \"{$identifier}\"";
            $properties = [
                'old' => $old,
            ];
        }

        ActivityLog::log(
            description: $description,
            subject: $this,
            event: $event,
            properties: $properties,
            logName: $logName
        );
    }

    /**
     * Resolve a human-friendly string identifier for the model.
     */
    protected function resolveActivityIdentifier(): string
    {
        if (isset($this->name)) {
            return (string) $this->name;
        }
        if (isset($this->title)) {
            return (string) $this->title;
        }
        if (isset($this->key)) {
            return (string) $this->key;
        }
        if (isset($this->email)) {
            return (string) $this->email;
        }

        return '#' . $this->getKey();
    }
}
