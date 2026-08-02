<?php

namespace App\Http\Controllers\Admin\DukunganAplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DukunganAplikasi\BackupDbRequest;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
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

        // 3. Fetch Existing Backup Files
        $backupFiles = [];
        $files = File::files($this->backupPath);
        foreach ($files as $file) {
            if ($file->getExtension() === 'sql') {
                $backupFiles[] = [
                    'name' => $file->getFilename(),
                    'size_mb' => round($file->getSize() / 1024 / 1024, 2),
                    'size_kb' => round($file->getSize() / 1024, 2),
                    'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                ];
            }
        }

        // Sort backups by newest first
        usort($backupFiles, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));

        return view('admin.dukunganaplikasi.backup-db', [
            'tables' => $tables,
            'dbName' => $dbName,
            'totalTables' => count($tables),
            'totalSizeMb' => round($totalSizeMb, 2),
            'backupFiles' => $backupFiles,
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
