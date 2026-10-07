<?php

namespace App\Console\Commands;

use App\Models\Admin\DukunganAplikasi\AppSetting;
use App\Services\DukunganAplikasi\CloudBackupService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ScheduledDatabaseBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup-scheduled {--force : Jalankan proses backup paksa tanpa menunggu jadwal cron}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Jalankan proses backup database otomatis terjadwal dan sinkronisasi ke cloud storage.';

    /**
     * Execute the console command.
     */
    public function handle(CloudBackupService $cloudService): int
    {
        $force = (bool) $this->option('force');
        $isEnabled = (bool) AppSetting::get('backup_schedule_enabled', 0);

        if (!$isEnabled && !$force) {
            $this->info('Jadwal backup otomatis sedang dinonaktifkan.');
            return 0;
        }

        // Evaluate cron schedule timing if not forced
        if (!$force && !$this->isDue()) {
            $this->info('Belum masuk waktu jadwal eksekusi backup.');
            return 0;
        }

        $this->info('Memulai proses backup database otomatis...');
        $startTime = microtime(true);

        try {
            $backupPath = storage_path('app/backups');
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            $dbName = DB::getDatabaseName();
            $backupType = AppSetting::get('backup_schedule_type', 'full');
            $includeCreateDb = (bool) AppSetting::get('backup_include_create_db', 1);
            $useGzip = (bool) AppSetting::get('backup_compression', 1);

            // Fetch target tables
            $rawTables = DB::select('SHOW TABLES');
            $keyName = "Tables_in_{$dbName}";
            $allTables = [];
            foreach ($rawTables as $item) {
                $tableName = $item->$keyName ?? null;
                if (!$tableName) {
                    $propArr = (array) $item;
                    $tableName = reset($propArr);
                }
                $allTables[] = $tableName;
            }

            if ($backupType === 'selective') {
                $selectedTablesJson = AppSetting::get('backup_schedule_tables', '[]');
                $selectedTables = is_string($selectedTablesJson) ? (json_decode($selectedTablesJson, true) ?: []) : (array) $selectedTablesJson;
                $targetTables = array_values(array_intersect($allTables, $selectedTables));
                if (empty($targetTables)) {
                    $targetTables = $allTables; // Fallback to full if empty
                }
            } else {
                $targetTables = $allTables;
            }

            // Build SQL Dump
            $sql = "-- ========================================================\n";
            $sql .= "-- RepaLogic Automated Scheduled DB Backup Dump\n";
            $sql .= "-- Generation Time: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- Database Name: `{$dbName}`\n";
            $sql .= "-- Backup Type: " . strtoupper($backupType) . " (" . count($targetTables) . " tables)\n";
            $sql .= "-- ========================================================\n\n";

            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
            $sql .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
            $sql .= "SET time_zone = \"+00:00\";\n\n";

            if ($includeCreateDb) {
                $sql .= "--\n-- Database Initialization Script\n--\n";
                $sql .= "DROP DATABASE IF EXISTS `{$dbName}`;\n";
                $sql .= "CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
                $sql .= "USE `{$dbName}`;\n\n";
            }

            foreach ($targetTables as $table) {
                $sql .= "--\n-- Table Structure for table `{$table}`\n--\n";
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";

                $createTableQuery = DB::select("SHOW CREATE TABLE `{$table}`");
                if (!empty($createTableQuery)) {
                    $createTableArr = (array) $createTableQuery[0];
                    $sql .= $createTableArr['Create Table'] . ";\n\n";
                }

                // Dump Data Rows in chunks
                $sql .= "--\n-- Dumping Data for table `{$table}`\n--\n";
                DB::table($table)->orderBy(DB::raw('1'))->chunk(500, function ($rows) use (&$sql, $table) {
                    if ($rows->count() > 0) {
                        $sql .= "INSERT INTO `{$table}` VALUES \n";
                        $values = [];

                        foreach ($rows as $row) {
                            $rowValues = [];
                            foreach ((array) $row as $val) {
                                if (is_null($val)) {
                                    $rowValues[] = "NULL";
                                } elseif (is_numeric($val)) {
                                    $rowValues[] = $val;
                                } else {
                                    $escaped = addslashes($val);
                                    $escaped = str_replace("\n", "\\n", $escaped);
                                    $escaped = str_replace("\r", "\\r", $escaped);
                                    $rowValues[] = "'{$escaped}'";
                                }
                            }
                            $values[] = "(" . implode(", ", $rowValues) . ")";
                        }

                        $sql .= implode(",\n", $values) . ";\n\n";
                    }
                });

                $sql .= "\n";
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            $sql .= "-- Dump End --\n";

            $timestamp = date('Ymd_His');
            $extension = ($useGzip && function_exists('gzencode')) ? 'sql.gz' : 'sql';
            $filename = "scheduled_backup_{$dbName}_{$backupType}_{$timestamp}.{$extension}";
            $filePath = $backupPath . '/' . $filename;

            if ($extension === 'sql.gz') {
                File::put($filePath, gzencode($sql, 9));
            } else {
                File::put($filePath, $sql);
            }

            $fileSizeBytes = File::size($filePath);
            $fileSizeFormatted = round($fileSizeBytes / 1024 / 1024, 2) . ' MB';

            $this->info("Berkas backup berhasil dibuat: {$filename} ({$fileSizeFormatted})");

            // Rotate & Clean Old Backups
            $this->rotateBackups($backupPath);

            // Cloud Sync if configured
            $cloudStatus = 'skipped';
            $cloudMessage = 'Cloud sync tidak diaktifkan.';
            $cloudDriver = AppSetting::get('backup_cloud_driver', 'none');

            if ($cloudDriver !== 'none' && !empty($cloudDriver)) {
                $this->info("Menyinkronkan ke Cloud Storage ({$cloudDriver})...");
                $cloudResult = $cloudService->upload($filePath);

                if (!empty($cloudResult['success'])) {
                    $cloudStatus = 'success';
                    $cloudMessage = $cloudResult['message'] ?? "Tersinkronkan ke {$cloudDriver}";
                    $this->info("Cloud Sync Berhasil: {$cloudMessage}");
                } else {
                    $cloudStatus = 'failed';
                    $cloudMessage = $cloudResult['message'] ?? "Gagal sinkronisasi ke {$cloudDriver}";
                    $this->error("Cloud Sync Gagal: {$cloudMessage}");
                }

                AppSetting::set('backup_last_cloud_sync_at', Carbon::now()->toDateTimeString());
                AppSetting::set('backup_last_cloud_sync_status', $cloudStatus);
            }

            $duration = round(microtime(true) - $startTime, 2);
            $summary = "Backup {$filename} ({$fileSizeFormatted}) selesai dalam {$duration} detik. " . ($cloudStatus !== 'skipped' ? "Cloud: {$cloudStatus}" : '');

            AppSetting::set('backup_last_run_at', Carbon::now()->toDateTimeString());
            AppSetting::set('backup_last_run_status', 'success');
            AppSetting::set('backup_last_run_message', $summary);

            Log::info("Automated Scheduled DB Backup Success: {$summary}");
            $this->info("Proses backup otomatis selesai dengan sukses!");

            return 0;
        } catch (\Throwable $e) {
            $duration = round(microtime(true) - $startTime, 2);
            $errorMessage = "Gagal: " . $e->getMessage();

            AppSetting::set('backup_last_run_at', Carbon::now()->toDateTimeString());
            AppSetting::set('backup_last_run_status', 'failed');
            AppSetting::set('backup_last_run_message', $errorMessage);

            Log::error("Automated Scheduled DB Backup Failed ({$duration}s): " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            $this->error("Proses backup gagal: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Check if the backup is due according to configured schedule frequency and time.
     */
    protected function isDue(): bool
    {
        $frequency = AppSetting::get('backup_schedule_frequency', 'daily');
        $timeStr = AppSetting::get('backup_schedule_time', '02:00');
        $scheduledDay = (int) AppSetting::get('backup_schedule_day', 1);

        $now = Carbon::now();
        $lastRunAt = AppSetting::get('backup_last_run_at');
        $lastRun = $lastRunAt ? Carbon::parse($lastRunAt) : null;

        // Parse hour and minute
        $timeParts = explode(':', $timeStr);
        $targetHour = (int) ($timeParts[0] ?? 2);
        $targetMinute = (int) ($timeParts[1] ?? 0);

        // Check if current hour and minute match
        if ($now->hour !== $targetHour || $now->minute !== $targetMinute) {
            return false;
        }

        // Daily Check: ensure not run yet today
        if ($frequency === 'daily') {
            if ($lastRun && $lastRun->isToday()) {
                return false;
            }
            return true;
        }

        // Weekly Check: dayOfWeekIso (1 = Monday, 7 = Sunday)
        if ($frequency === 'weekly') {
            if ($now->dayOfWeekIso !== $scheduledDay) {
                return false;
            }
            if ($lastRun && $lastRun->isSameWeek($now)) {
                return false;
            }
            return true;
        }

        // Monthly Check: day of month
        if ($frequency === 'monthly') {
            if ($now->day !== $scheduledDay) {
                return false;
            }
            if ($lastRun && $lastRun->isSameMonth($now)) {
                return false;
            }
            return true;
        }

        return false;
    }

    /**
     * Prune and rotate old backup files according to retention policies.
     */
    protected function rotateBackups(string $backupPath): void
    {
        $retentionDays = (int) AppSetting::get('backup_retention_days', 7);
        $maxFiles = (int) AppSetting::get('backup_max_files', 10);

        $files = File::files($backupPath);
        $backupFileList = [];

        foreach ($files as $file) {
            $ext = $file->getExtension();
            if ($ext === 'sql' || str_ends_with($file->getFilename(), '.sql.gz')) {
                $backupFileList[] = [
                    'path' => $file->getPathname(),
                    'mtime' => $file->getMTime(),
                ];
            }
        }

        // 1. Age-based rotation
        if ($retentionDays > 0) {
            $thresholdTime = Carbon::now()->subDays($retentionDays)->timestamp;
            foreach ($backupFileList as $index => $item) {
                if ($item['mtime'] < $thresholdTime) {
                    File::delete($item['path']);
                    unset($backupFileList[$index]);
                }
            }
        }

        // 2. Max file count-based rotation
        if ($maxFiles > 0 && count($backupFileList) > $maxFiles) {
            // Sort oldest first
            usort($backupFileList, fn($a, $b) => $a['mtime'] <=> $b['mtime']);
            $excessCount = count($backupFileList) - $maxFiles;

            for ($i = 0; $i < $excessCount; $i++) {
                if (isset($backupFileList[$i])) {
                    File::delete($backupFileList[$i]['path']);
                }
            }
        }
    }
}
