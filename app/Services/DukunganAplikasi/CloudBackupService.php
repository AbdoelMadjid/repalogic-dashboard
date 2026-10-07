<?php

namespace App\Services\DukunganAplikasi;

use App\Models\Admin\DukunganAplikasi\AppSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudBackupService
{
    /**
     * Test connection to configured Cloud Storage.
     */
    public function testConnection(string $driver, array $config = []): array
    {
        if ($driver === 's3') {
            return $this->testS3Connection($config);
        }

        if ($driver === 'gdrive') {
            return $this->testGDriveConnection($config);
        }

        return [
            'success' => false,
            'message' => 'Driver cloud storage tidak valid.',
        ];
    }

    /**
     * Upload local backup file to the currently configured Cloud Storage.
     */
    public function upload(string $filePath): array
    {
        $driver = AppSetting::get('backup_cloud_driver', 'none');

        if ($driver === 'none' || empty($driver)) {
            return [
                'success' => true,
                'skipped' => true,
                'message' => 'Sinkronisasi cloud dinonaktifkan (driver: none).',
            ];
        }

        if (!File::exists($filePath)) {
            return [
                'success' => false,
                'message' => "Berkas lokal '{$filePath}' tidak ditemukan.",
            ];
        }

        if ($driver === 's3') {
            $config = [
                'key' => AppSetting::get('backup_cloud_s3_key', ''),
                'secret' => AppSetting::get('backup_cloud_s3_secret', ''),
                'region' => AppSetting::get('backup_cloud_s3_region', 'ap-southeast-1'),
                'bucket' => AppSetting::get('backup_cloud_s3_bucket', ''),
                'endpoint' => AppSetting::get('backup_cloud_s3_endpoint', ''),
                'use_path_style' => (bool) AppSetting::get('backup_cloud_s3_use_path_style', 0),
            ];
            return $this->uploadToS3($filePath, $config);
        }

        if ($driver === 'gdrive') {
            $config = [
                'folder_id' => AppSetting::get('backup_cloud_gdrive_folder_id', ''),
                'service_account' => AppSetting::get('backup_cloud_gdrive_service_account', ''),
            ];
            return $this->uploadToGDrive($filePath, $config);
        }

        return [
            'success' => false,
            'message' => "Driver '{$driver}' tidak didukung.",
        ];
    }

    /**
     * Test AWS S3 / S3-Compatible Connection (Bucket existence check).
     */
    public function testS3Connection(array $config): array
    {
        $key = trim($config['key'] ?? '');
        $secret = trim($config['secret'] ?? '');
        $region = trim($config['region'] ?? 'ap-southeast-1') ?: 'ap-southeast-1';
        $bucket = trim($config['bucket'] ?? '');
        $endpoint = trim($config['endpoint'] ?? '');
        $usePathStyle = !empty($config['use_path_style']);

        if (empty($key) || empty($secret) || empty($bucket)) {
            return [
                'success' => false,
                'message' => 'Access Key, Secret Key, dan Bucket Name wajib diisi.',
            ];
        }

        try {
            $host = $this->resolveS3Host($bucket, $region, $endpoint, $usePathStyle);
            $uriPath = $usePathStyle || !empty($endpoint) ? "/{$bucket}" : '/';
            $url = (str_starts_with($endpoint, 'http://') ? 'http://' : 'https://') . $host . $uriPath;

            $headers = $this->generateAwsV4Headers('HEAD', $url, '', 's3', $region, $key, $secret, $host);

            $response = Http::timeout(10)->withHeaders($headers)->head($url);

            if ($response->successful() || $response->status() === 200) {
                return [
                    'success' => true,
                    'message' => "Koneksi ke S3 Bucket '{$bucket}' berhasil! (Status HTTP {$response->status()})",
                ];
            }

            if ($response->status() === 403) {
                return [
                    'success' => false,
                    'message' => "Akses Ditolak (HTTP 403). Periksa apakah Access Key & Secret Key memiliki izin akses ke bucket '{$bucket}'.",
                ];
            }

            if ($response->status() === 404) {
                return [
                    'success' => false,
                    'message' => "Bucket '{$bucket}' tidak ditemukan (HTTP 404). Periksa nama bucket dan region.",
                ];
            }

            return [
                'success' => false,
                'message' => "Gagal terhubung ke S3 Bucket '{$bucket}' (HTTP Status: {$response->status()}).",
            ];
        } catch (\Throwable $e) {
            Log::error('S3 Connection Test Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi S3: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Upload backup file to S3 / S3-Compatible Storage.
     */
    public function uploadToS3(string $filePath, array $config): array
    {
        $key = trim($config['key'] ?? '');
        $secret = trim($config['secret'] ?? '');
        $region = trim($config['region'] ?? 'ap-southeast-1') ?: 'ap-southeast-1';
        $bucket = trim($config['bucket'] ?? '');
        $endpoint = trim($config['endpoint'] ?? '');
        $usePathStyle = !empty($config['use_path_style']);

        if (empty($key) || empty($secret) || empty($bucket)) {
            return [
                'success' => false,
                'message' => 'Kredensial S3 belum lengkap.',
            ];
        }

        try {
            $fileName = basename($filePath);
            $fileContent = File::get($filePath);
            $mimeType = str_ends_with($fileName, '.gz') ? 'application/gzip' : 'application/sql';

            $host = $this->resolveS3Host($bucket, $region, $endpoint, $usePathStyle);
            $objectPath = "repalogic_backups/{$fileName}";
            $uriPath = ($usePathStyle || !empty($endpoint)) ? "/{$bucket}/{$objectPath}" : "/{$objectPath}";
            $url = (str_starts_with($endpoint, 'http://') ? 'http://' : 'https://') . $host . $uriPath;

            $headers = $this->generateAwsV4Headers('PUT', $url, $fileContent, 's3', $region, $key, $secret, $host, [
                'Content-Type' => $mimeType,
            ]);

            $response = Http::timeout(60)
                ->withHeaders($headers)
                ->withBody($fileContent, $mimeType)
                ->put($url);

            if ($response->successful() || in_array($response->status(), [200, 201])) {
                Log::info("Backup {$fileName} successfully uploaded to S3 bucket {$bucket}/{$objectPath}");
                return [
                    'success' => true,
                    'message' => "Berkas '{$fileName}' berhasil disinkronkan ke S3 Bucket ({$bucket}/{$objectPath}).",
                ];
            }

            Log::error("S3 Upload Failed: HTTP {$response->status()} - {$response->body()}");
            return [
                'success' => false,
                'message' => "Gagal mengunggah ke S3 (HTTP {$response->status()}): " . substr($response->body(), 0, 200),
            ];
        } catch (\Throwable $e) {
            Log::error('S3 Upload Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Kesalahan saat mengunggah ke S3: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Test Google Drive Connection / Service Account.
     */
    public function testGDriveConnection(array $config): array
    {
        $folderId = trim($config['folder_id'] ?? '');
        $serviceAccountJson = trim($config['service_account'] ?? '');

        if (empty($folderId)) {
            return [
                'success' => false,
                'message' => 'Google Drive Folder ID wajib diisi.',
            ];
        }

        if (empty($serviceAccountJson)) {
            return [
                'success' => false,
                'message' => 'Kredensial Service Account JSON / Access Token Google Drive wajib diisi.',
            ];
        }

        try {
            $token = $this->resolveGDriveAccessToken($serviceAccountJson);
            if (!$token) {
                return [
                    'success' => false,
                    'message' => 'Gagal mengautentikasi kredensial Google Drive Service Account.',
                ];
            }

            // Verify folder access
            $url = "https://www.googleapis.com/drive/v3/files/{$folderId}?fields=id,name,mimeType,trashed";
            $response = Http::timeout(10)
                ->withToken($token)
                ->get($url);

            if ($response->successful()) {
                $folderData = $response->json();
                $folderName = $folderData['name'] ?? $folderId;
                return [
                    'success' => true,
                    'message' => "Koneksi ke Google Drive Folder '{$folderName}' berhasil diverifikasi!",
                ];
            }

            return [
                'success' => false,
                'message' => "Gagal mengakses Folder Google Drive (HTTP {$response->status()}): " . ($response->json('error.message') ?? $response->body()),
            ];
        } catch (\Throwable $e) {
            Log::error('GDrive Connection Test Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi Google Drive: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Upload backup file to Google Drive.
     */
    public function uploadToGDrive(string $filePath, array $config): array
    {
        $folderId = trim($config['folder_id'] ?? '');
        $serviceAccountJson = trim($config['service_account'] ?? '');

        if (empty($folderId) || empty($serviceAccountJson)) {
            return [
                'success' => false,
                'message' => 'Konfigurasi Google Drive (Folder ID & Service Account) belum lengkap.',
            ];
        }

        try {
            $token = $this->resolveGDriveAccessToken($serviceAccountJson);
            if (!$token) {
                return [
                    'success' => false,
                    'message' => 'Gagal mengautentikasi kredensial Google Drive.',
                ];
            }

            $fileName = basename($filePath);
            $fileContent = File::get($filePath);
            $mimeType = str_ends_with($fileName, '.gz') ? 'application/gzip' : 'application/sql';

            // Multipart upload metadata
            $metadata = [
                'name' => $fileName,
                'parents' => [$folderId],
            ];

            $boundary = '-------RepaLogicBackup' . md5(time());
            $delimiter = "\r\n--" . $boundary . "\r\n";
            $closeDelimiter = "\r\n--" . $boundary . "--";

            $body = $delimiter
                . "Content-Type: application/json; charset=UTF-8\r\n\r\n"
                . json_encode($metadata)
                . $delimiter
                . "Content-Type: {$mimeType}\r\n\r\n"
                . $fileContent
                . $closeDelimiter;

            $uploadUrl = 'https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart';

            $response = Http::timeout(60)
                ->withToken($token)
                ->withHeaders([
                    'Content-Type' => 'multipart/related; boundary=' . $boundary,
                    'Content-Length' => (string) strlen($body),
                ])
                ->withBody($body, 'multipart/related; boundary=' . $boundary)
                ->post($uploadUrl);

            if ($response->successful()) {
                $fileId = $response->json('id');
                Log::info("Backup {$fileName} successfully uploaded to Google Drive (File ID: {$fileId})");
                return [
                    'success' => true,
                    'message' => "Berkas '{$fileName}' berhasil disinkronkan ke Google Drive (ID: {$fileId}).",
                ];
            }

            Log::error("GDrive Upload Failed: HTTP {$response->status()} - {$response->body()}");
            return [
                'success' => false,
                'message' => "Gagal mengunggah ke Google Drive (HTTP {$response->status()}): " . ($response->json('error.message') ?? $response->body()),
            ];
        } catch (\Throwable $e) {
            Log::error('GDrive Upload Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Kesalahan saat mengunggah ke Google Drive: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Resolve OAuth2 Access Token for Google Drive using JWT & Service Account.
     */
    protected function resolveGDriveAccessToken(string $credentials): ?string
    {
        // If raw access token provided directly
        if (str_starts_with($credentials, 'ya29.')) {
            return $credentials;
        }

        $json = json_decode($credentials, true);
        if (!$json || empty($json['client_email']) || empty($json['private_key'])) {
            return null;
        }

        $now = time();
        $jwtHeader = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $jwtPayload = base64_encode(json_encode([
            'iss' => $json['client_email'],
            'scope' => 'https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ]));

        $rawHeaderPayload = "{$jwtHeader}.{$jwtPayload}";
        $binarySignature = '';
        $privateKey = openssl_pkey_get_private($json['private_key']);
        if (!$privateKey) {
            return null;
        }

        openssl_sign($rawHeaderPayload, $binarySignature, $privateKey, OPENSSL_ALGO_SHA256);
        $jwtSignature = base64_encode($binarySignature);
        $jwt = "{$rawHeaderPayload}.{$jwtSignature}";

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if ($tokenResponse->successful()) {
            return $tokenResponse->json('access_token');
        }

        Log::error('GDrive Service Account Token Exchange Failed: ' . $tokenResponse->body());
        return null;
    }

    /**
     * Resolve S3 host domain.
     */
    protected function resolveS3Host(string $bucket, string $region, string $endpoint, bool $usePathStyle): string
    {
        if (!empty($endpoint)) {
            $parsed = parse_url($endpoint);
            $host = $parsed['host'] ?? $endpoint;
            if (isset($parsed['port'])) {
                $host .= ':' . $parsed['port'];
            }
            return $host;
        }

        if ($usePathStyle) {
            return ($region === 'us-east-1') ? 's3.amazonaws.com' : "s3.{$region}.amazonaws.com";
        }

        return ($region === 'us-east-1')
            ? "{$bucket}.s3.amazonaws.com"
            : "{$bucket}.s3.{$region}.amazonaws.com";
    }

    /**
     * Generate AWS Signature Version 4 Headers for native REST requests.
     */
    protected function generateAwsV4Headers(
        string $method,
        string $url,
        string $payload,
        string $service,
        string $region,
        string $accessKey,
        string $secretKey,
        string $host,
        array $extraHeaders = []
    ): array {
        $parsedUrl = parse_url($url);
        $canonicalUri = $parsedUrl['path'] ?? '/';
        $canonicalQuery = $parsedUrl['query'] ?? '';

        $amzDate = gmdate('Ymd\THis\Z');
        $dateStamp = gmdate('Ymd');
        $payloadHash = hash('sha256', $payload);

        $headersToSign = array_merge([
            'host' => $host,
            'x-amz-content-sha256' => $payloadHash,
            'x-amz-date' => $amzDate,
        ], array_change_key_case($extraHeaders, CASE_LOWER));

        ksort($headersToSign);

        $canonicalHeaders = '';
        $signedHeadersList = [];
        foreach ($headersToSign as $name => $value) {
            $canonicalHeaders .= strtolower($name) . ':' . trim($value) . "\n";
            $signedHeadersList[] = strtolower($name);
        }
        $signedHeaders = implode(';', $signedHeadersList);

        $canonicalRequest = implode("\n", [
            $method,
            $canonicalUri,
            $canonicalQuery,
            $canonicalHeaders,
            $signedHeaders,
            $payloadHash,
        ]);

        $credentialScope = "{$dateStamp}/{$region}/{$service}/aws4_request";
        $stringToSign = implode("\n", [
            'AWS4-HMAC-SHA256',
            $amzDate,
            $credentialScope,
            hash('sha256', $canonicalRequest),
        ]);

        // Signing Key calculation
        $kDate = hash_hmac('sha256', $dateStamp, "AWS4{$secretKey}", true);
        $kRegion = hash_hmac('sha256', $region, $kDate, true);
        $kService = hash_hmac('sha256', $service, $kRegion, true);
        $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);

        $signature = hash_hmac('sha256', $stringToSign, $kSigning);
        $authorizationHeader = "AWS4-HMAC-SHA256 Credential={$accessKey}/{$credentialScope}, SignedHeaders={$signedHeaders}, Signature={$signature}";

        return array_merge($extraHeaders, [
            'Host' => $host,
            'x-amz-date' => $amzDate,
            'x-amz-content-sha256' => $payloadHash,
            'Authorization' => $authorizationHeader,
        ]);
    }
}
