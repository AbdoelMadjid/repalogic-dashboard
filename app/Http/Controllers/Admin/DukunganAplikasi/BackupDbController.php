<?php

namespace App\Http\Controllers\Admin\DukunganAplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DukunganAplikasi\BackupDbRequest;
use App\Models\Admin\DukunganAplikasi\AppSetting;
use App\Services\DukunganAplikasi\CloudBackupService;
use App\Traits\HasNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class BackupDbController extends Controller
{
    use HasNotification;

    protected string $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    /**
     * Display backup dashboard with database tables & relationship stats.
     */
    public function index()
    {
        $dbName = DB::getDatabaseName();
        $rawTables = DB::select('SHOW TABLES');
        $keyName = "Tables_in_{$dbName}";

        // 1. Fetch Foreign Key Constraints from information_schema
        $foreignKeys = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->select('TABLE_NAME', 'COLUMN_NAME', 'REFERENCED_TABLE_NAME', 'REFERENCED_COLUMN_NAME')
            ->where('TABLE_SCHEMA', $dbName)
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->get();

        // 2. Fetch Table Size Information
        $tableSizes = DB::table('information_schema.TABLES')
            ->select('TABLE_NAME', DB::raw('ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024), 2) AS size_mb'))
            ->where('TABLE_SCHEMA', $dbName)
            ->pluck('size_mb', 'TABLE_NAME');

        $tables = [];
        $totalSizeMb = 0;

        foreach ($rawTables as $item) {
            $tableName = $item->$keyName ?? null;
            if (!$tableName) {
                $propArr = (array) $item;
                $tableName = reset($propArr);
            }

            // Find parents (tables referenced by this table)
            $parents = $foreignKeys->where('TABLE_NAME', $tableName)
                ->pluck('REFERENCED_TABLE_NAME')
                ->unique()
                ->values()
                ->all();

            // Find children (tables referencing this table)
            $children = $foreignKeys->where('REFERENCED_TABLE_NAME', $tableName)
                ->pluck('TABLE_NAME')
                ->unique()
                ->values()
                ->all();

            $rowCount = DB::table($tableName)->count();
            $sizeMb = (float) ($tableSizes[$tableName] ?? 0);
            $totalSizeMb += $sizeMb;

            $tables[] = [
                'name' => $tableName,
                'rows' => $rowCount,
                'size_mb' => $sizeMb,
                'parents' => $parents,
                'children' => $children,
                'has_relations' => (!empty($parents) || !empty($children)),
            ];
        }

        // 3. Fetch Existing Backup Files (.sql and .sql.gz)
        $backupFiles = [];
        $files = File::files($this->backupPath);
        foreach ($files as $file) {
            $ext = $file->getExtension();
            $filename = $file->getFilename();
            if ($ext === 'sql' || str_ends_with($filename, '.sql.gz')) {
                $backupFiles[] = [
                    'name' => $filename,
                    'is_compressed' => str_ends_with($filename, '.sql.gz'),
                    'size_mb' => round($file->getSize() / 1024 / 1024, 2),
                    'size_kb' => round($file->getSize() / 1024, 2),
                    'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                ];
            }
        }

        // Sort backups by newest first
        usort($backupFiles, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));

        // 4. Configuration Data from AppSetting
        $scheduleConfig = [
            'enabled' => (bool) AppSetting::get('backup_schedule_enabled', 0),
            'frequency' => AppSetting::get('backup_schedule_frequency', 'daily'),
            'time' => AppSetting::get('backup_schedule_time', '02:00'),
            'day' => (string) AppSetting::get('backup_schedule_day', '1'),
            'type' => AppSetting::get('backup_schedule_type', 'full'),
            'tables' => json_decode(AppSetting::get('backup_schedule_tables', '[]'), true) ?: [],
            'retention_days' => (int) AppSetting::get('backup_retention_days', 7),
            'max_files' => (int) AppSetting::get('backup_max_files', 10),
            'compression' => (bool) AppSetting::get('backup_compression', 1),
            'include_create_db' => (bool) AppSetting::get('backup_include_create_db', 1),
            'last_run_at' => AppSetting::get('backup_last_run_at'),
            'last_run_status' => AppSetting::get('backup_last_run_status'),
            'last_run_message' => AppSetting::get('backup_last_run_message'),
        ];

        $cloudConfig = [
            'driver' => AppSetting::get('backup_cloud_driver', 'none'),
            's3_key' => AppSetting::get('backup_cloud_s3_key', ''),
            's3_secret' => AppSetting::get('backup_cloud_s3_secret', ''),
            's3_region' => AppSetting::get('backup_cloud_s3_region', 'ap-southeast-1'),
            's3_bucket' => AppSetting::get('backup_cloud_s3_bucket', ''),
            's3_endpoint' => AppSetting::get('backup_cloud_s3_endpoint', ''),
            's3_use_path_style' => (bool) AppSetting::get('backup_cloud_s3_use_path_style', 0),
            'gdrive_folder_id' => AppSetting::get('backup_cloud_gdrive_folder_id', ''),
            'gdrive_service_account' => AppSetting::get('backup_cloud_gdrive_service_account', ''),
            'last_sync_at' => AppSetting::get('backup_last_cloud_sync_at'),
            'last_sync_status' => AppSetting::get('backup_last_cloud_sync_status'),
        ];

        return view('admin.dukunganaplikasi.backup-db', [
            'tables' => $tables,
            'dbName' => $dbName,
            'totalTables' => count($tables),
            'totalSizeMb' => round($totalSizeMb, 2),
            'backupFiles' => $backupFiles,
            'scheduleConfig' => $scheduleConfig,
            'cloudConfig' => $cloudConfig,
        ]);
    }

    /**
     * Process Full or Selective Database Backup export.
     */
    public function processBackup(BackupDbRequest $request)
    {
        $dbName = DB::getDatabaseName();
        $backupType = $request->input('backup_type', 'full');
        $includeCreateDb = $request->boolean('include_create_db');
        $outputTarget = $request->input('output_target', 'download');

        // Determine target tables
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
            $selectedTables = $request->input('tables', []);
            $targetTables = array_values(array_intersect($allTables, $selectedTables));
            if (empty($targetTables)) {
                $this->notifyError('Pilih minimal satu tabel valid untuk melakukan backup.', 'Gagal!');
                return redirect()->back();
            }
        } else {
            $targetTables = $allTables;
        }

        // Build SQL Dump String
        $sql = "-- ========================================================\n";
        $sql .= "-- RepaLogic Dashboard Database Backup Dump\n";
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

            // Dump Data Rows
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
        $filename = "backup_{$dbName}_{$backupType}_{$timestamp}.sql";

        if ($outputTarget === 'download') {
            return Response::make($sql, 200, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        // Save to Storage
        $filePath = $this->backupPath . '/' . $filename;
        File::put($filePath, $sql);

        $this->notifySuccess("Berkas backup '{$filename}' berhasil dibuat dan disimpan di storage.", 'Backup Berhasil!');
        return redirect()->route('admin.dukunganaplikasi.backup-db.index');
    }

    /**
     * Save automated backup schedule configuration.
     */
    public function saveSchedule(Request $request)
    {
        if (!auth()->user()->can('create dukunganaplikasi/backup-db') && !auth()->user()->can('update dukunganaplikasi/backup-db')) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'backup_schedule_enabled' => 'nullable|boolean',
            'backup_schedule_frequency' => 'required|in:daily,weekly,monthly',
            'backup_schedule_time' => 'required|date_format:H:i',
            'backup_schedule_day' => 'nullable|numeric|min:1|max:31',
            'backup_schedule_type' => 'required|in:full,selective',
            'backup_schedule_tables' => 'nullable|array',
            'backup_retention_days' => 'required|numeric|min:0|max:365',
            'backup_max_files' => 'required|numeric|min:1|max:100',
            'backup_compression' => 'nullable|boolean',
            'backup_include_create_db' => 'nullable|boolean',
        ]);

        AppSetting::set('backup_schedule_enabled', $request->boolean('backup_schedule_enabled') ? 1 : 0);
        AppSetting::set('backup_schedule_frequency', $validated['backup_schedule_frequency']);
        AppSetting::set('backup_schedule_time', $validated['backup_schedule_time']);
        AppSetting::set('backup_schedule_day', $validated['backup_schedule_day'] ?? 1);
        AppSetting::set('backup_schedule_type', $validated['backup_schedule_type']);
        AppSetting::set('backup_schedule_tables', json_encode($request->input('backup_schedule_tables', [])));
        AppSetting::set('backup_retention_days', (int) $validated['backup_retention_days']);
        AppSetting::set('backup_max_files', (int) $validated['backup_max_files']);
        AppSetting::set('backup_compression', $request->boolean('backup_compression') ? 1 : 0);
        AppSetting::set('backup_include_create_db', $request->boolean('backup_include_create_db') ? 1 : 0);

        AppSetting::clearCache();

        $this->notifySuccess('Konfigurasi jadwal backup otomatis berhasil disimpan.', 'Jadwal Disimpan!');
        return redirect()->route('admin.dukunganaplikasi.backup-db.index');
    }

    /**
     * Save cloud storage sync configuration.
     */
    public function saveCloud(Request $request)
    {
        if (!auth()->user()->can('create dukunganaplikasi/backup-db') && !auth()->user()->can('update dukunganaplikasi/backup-db')) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'backup_cloud_driver' => 'required|in:none,s3,gdrive',
            'backup_cloud_s3_key' => 'nullable|string|max:255',
            'backup_cloud_s3_secret' => 'nullable|string|max:255',
            'backup_cloud_s3_region' => 'nullable|string|max:100',
            'backup_cloud_s3_bucket' => 'nullable|string|max:255',
            'backup_cloud_s3_endpoint' => 'nullable|string|max:255',
            'backup_cloud_s3_use_path_style' => 'nullable|boolean',
            'backup_cloud_gdrive_folder_id' => 'nullable|string|max:255',
            'backup_cloud_gdrive_service_account' => 'nullable|string',
        ]);

        AppSetting::set('backup_cloud_driver', $validated['backup_cloud_driver']);

        if ($validated['backup_cloud_driver'] === 's3') {
            AppSetting::set('backup_cloud_s3_key', $request->input('backup_cloud_s3_key', ''));
            if ($request->filled('backup_cloud_s3_secret')) {
                AppSetting::set('backup_cloud_s3_secret', $request->input('backup_cloud_s3_secret'));
            }
            AppSetting::set('backup_cloud_s3_region', $request->input('backup_cloud_s3_region', 'ap-southeast-1'));
            AppSetting::set('backup_cloud_s3_bucket', $request->input('backup_cloud_s3_bucket', ''));
            AppSetting::set('backup_cloud_s3_endpoint', $request->input('backup_cloud_s3_endpoint', ''));
            AppSetting::set('backup_cloud_s3_use_path_style', $request->boolean('backup_cloud_s3_use_path_style') ? 1 : 0);
        } elseif ($validated['backup_cloud_driver'] === 'gdrive') {
            AppSetting::set('backup_cloud_gdrive_folder_id', $request->input('backup_cloud_gdrive_folder_id', ''));
            if ($request->filled('backup_cloud_gdrive_service_account')) {
                AppSetting::set('backup_cloud_gdrive_service_account', $request->input('backup_cloud_gdrive_service_account'));
            }
        }

        AppSetting::clearCache();

        $this->notifySuccess('Konfigurasi sinkronisasi Cloud Storage berhasil diperbarui.', 'Konfigurasi Disimpan!');
        return redirect()->route('admin.dukunganaplikasi.backup-db.index');
    }

    /**
     * Test Cloud Storage Connection via AJAX.
     */
    public function testCloud(Request $request, CloudBackupService $cloudService)
    {
        $driver = $request->input('driver', 's3');

        $config = [];
        if ($driver === 's3') {
            $config = [
                'key' => $request->input('s3_key') ?: AppSetting::get('backup_cloud_s3_key', ''),
                'secret' => $request->input('s3_secret') ?: AppSetting::get('backup_cloud_s3_secret', ''),
                'region' => $request->input('s3_region') ?: AppSetting::get('backup_cloud_s3_region', 'ap-southeast-1'),
                'bucket' => $request->input('s3_bucket') ?: AppSetting::get('backup_cloud_s3_bucket', ''),
                'endpoint' => $request->input('s3_endpoint') ?: AppSetting::get('backup_cloud_s3_endpoint', ''),
                'use_path_style' => $request->boolean('s3_use_path_style', false),
            ];
        } elseif ($driver === 'gdrive') {
            $config = [
                'folder_id' => $request->input('gdrive_folder_id') ?: AppSetting::get('backup_cloud_gdrive_folder_id', ''),
                'service_account' => $request->input('gdrive_service_account') ?: AppSetting::get('backup_cloud_gdrive_service_account', ''),
            ];
        }

        $result = $cloudService->testConnection($driver, $config);

        return response()->json($result);
    }

    /**
     * Manually trigger the scheduled backup command immediately.
     */
    public function runScheduledNow(CloudBackupService $cloudService)
    {
        if (!auth()->user()->can('create dukunganaplikasi/backup-db')) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $exitCode = Artisan::call('db:backup-scheduled', ['--force' => true]);
        $message = AppSetting::get('backup_last_run_message', 'Proses eksekusi backup selesai.');

        if ($exitCode === 0) {
            $this->notifySuccess($message, 'Backup Terjadwal Berhasil!');
        } else {
            $this->notifyError($message, 'Backup Terjadwal Gagal!');
        }

        return redirect()->route('admin.dukunganaplikasi.backup-db.index');
    }

    /**
     * Upload / Sync an existing local backup file to Cloud Storage.
     */
    public function syncFileToCloud(string $filename, CloudBackupService $cloudService)
    {
        if (!auth()->user()->can('create dukunganaplikasi/backup-db') && !auth()->user()->can('update dukunganaplikasi/backup-db')) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $filePath = $this->backupPath . '/' . basename($filename);
        if (!File::exists($filePath)) {
            $this->notifyError("Berkas '{$filename}' tidak ditemukan di storage lokal.", 'Gagal!');
            return redirect()->back();
        }

        $driver = AppSetting::get('backup_cloud_driver', 'none');
        if ($driver === 'none' || empty($driver)) {
            $this->notifyWarning('Pilih dan konfigurasikan penyedia Cloud Storage (AWS S3 atau Google Drive) terlebih dahulu pada tab Pengaturan Cloud.', 'Cloud Sync Nonaktif');
            return redirect()->back();
        }

        $result = $cloudService->upload($filePath);

        if (!empty($result['success'])) {
            $this->notifySuccess($result['message'] ?? "Berkas berhasil disinkronkan ke {$driver}.", 'Sync Cloud Berhasil!');
        } else {
            $this->notifyError($result['message'] ?? "Gagal menyinkronkan berkas ke {$driver}.", 'Sync Cloud Gagal!');
        }

        return redirect()->route('admin.dukunganaplikasi.backup-db.index');
    }

    /**
     * Download saved backup file from storage.
     */
    public function download(string $filename)
    {
        $filePath = $this->backupPath . '/' . basename($filename);

        if (!File::exists($filePath)) {
            $this->notifyError("Berkas backup '{$filename}' tidak ditemukan.", 'Gagal!');
            return redirect()->back();
        }

        return Response::download($filePath);
    }

    /**
     * Delete backup file from storage.
     */
    public function destroy(string $filename)
    {
        $filePath = $this->backupPath . '/' . basename($filename);

        if (File::exists($filePath)) {
            File::delete($filePath);
            $this->notifySuccess("Berkas backup '{$filename}' berhasil dihapus.", 'Berhasil!');
        } else {
            $this->notifyError("Berkas backup '{$filename}' tidak ditemukan.", 'Gagal!');
        }

        return redirect()->route('admin.dukunganaplikasi.backup-db.index');
    }
}
