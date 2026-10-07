<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManajemenPengguna\UserRequest;
use App\Models\User;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    use HasNotification;

    /**
     * Display a listing of users and available Spatie roles.
     */
    public function index(Request $request)
    {
        $users = User::with(['roles', 'approver', 'detail', 'config'])->latest()->get();
        foreach ($users as $user) {
            $user->role_names = $user->roles->pluck('name')->toArray();
            $user->cover_bg_url = $user->cover_bg_url;
            $user->cover_position_y = $user->cover_position_y;
        }
        $roles = Role::all();

        return view('admin.manajemenpengguna.users', compact('users', 'roles'));
    }

    public function create()
    {
        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Store a newly created user account.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'avatar' => $avatarPath,
            'status' => $validated['status'] ?? 'active',
            'approved_at' => ($validated['status'] ?? 'active') === 'active' ? now() : null,
            'approved_by' => ($validated['status'] ?? 'active') === 'active' ? auth()->id() : null,
        ]);

        if ($avatarPath) {
            \App\Models\UserMediaHistory::create([
                'user_id' => $user->id,
                'media_type' => 'avatar',
                'file_path' => $avatarPath,
                'file_name' => $request->file('avatar')->getClientOriginalName(),
                'description' => 'Foto Avatar Pengguna Baru (Admin)',
                'meta_data' => [
                    'source' => 'admin_user_create',
                    'created_by' => auth()->id(),
                ],
            ]);
        }

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Pengguna baru \"{$user->name}\" berhasil ditambahkan.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    public function show($id)
    {
        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    public function edit($id)
    {
        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Update the specified user profile and roles.
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        $userData = [
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
        ];

        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;

            \App\Models\UserMediaHistory::create([
                'user_id' => $user->id,
                'media_type' => 'avatar',
                'file_path' => $avatarPath,
                'file_name' => $request->file('avatar')->getClientOriginalName(),
                'description' => 'Pembaruan Foto Avatar Pengguna (Admin)',
                'meta_data' => [
                    'source' => 'admin_user_update',
                    'updated_by' => auth()->id(),
                ],
            ]);
        } elseif ($request->boolean('remove_avatar')) {
            if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = null;
        }

        if (isset($validated['status'])) {
            $userData['status'] = $validated['status'];
            if ($validated['status'] === 'active' && $user->status === 'pending') {
                $userData['approved_at'] = now();
                $userData['approved_by'] = auth()->id();
            }
        }

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        if ($request->has('details')) {
            $detailData = $request->input('details', []);
            if ($request->hasFile('details.foto_ktp')) {
                $detail = $user->detail;
                if ($detail && !empty($detail->foto_ktp) && Storage::disk('public')->exists($detail->foto_ktp)) {
                    Storage::disk('public')->delete($detail->foto_ktp);
                }
                $detailData['foto_ktp'] = $request->file('details.foto_ktp')->store('ktp', 'public');
            }
            $user->detail()->updateOrCreate(['user_id' => $user->id], $detailData);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Data pengguna \"{$user->name}\" berhasil diperbarui.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Approve self-registered user and assign default 'user' role.
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);

        // Pastikan role 'user' tersedia
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $user->update([
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        // Otomatis assign role 'user' jika akun belum memiliki role
        if ($user->roles->isEmpty()) {
            $user->assignRole('user');
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Akun pengguna \"{$user->name}\" berhasil disetujui & diaktifkan dengan Role User.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Reset user password to standard default password ("password*").
     */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make('password*'),
            'password_reset_requested_at' => null,
        ]);

        $this->notifySuccess("Password pengguna \"{$user->name}\" berhasil di-reset menjadi \"password*\".");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Deactivate user upon request.
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            $this->notifyError("Anda tidak dapat menonaktifkan akun Anda sendiri dari sini.");
            return redirect()->route('admin.manajemenpengguna.users.index');
        }

        $user->update([
            'status' => 'inactive',
            'deactivation_requested_at' => null,
            'deactivation_reason' => null,
        ]);

        // Hancurkan seluruh sesi aktif akun ini dan bersihkan status online
        try {
            \Illuminate\Support\Facades\DB::table('sessions')->where('user_id', $user->id)->delete();
        } catch (\Throwable $e) {}

        \Illuminate\Support\Facades\Cache::forget('user-online-' . $user->id);
        $onlineList = \Illuminate\Support\Facades\Cache::get('online-users-list', []);
        if (in_array($user->id, $onlineList)) {
            $onlineList = array_values(array_diff($onlineList, [$user->id]));
            \Illuminate\Support\Facades\Cache::put('online-users-list', $onlineList, now()->addMinutes(3));
        }

        $this->notifySuccess("Akun pengguna \"{$user->name}\" telah dinonaktifkan sesuai permohonan.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Reject self-registration request.
     */
    public function rejectRegistration(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $reason = trim($request->input('reason', 'Pendaftaran tidak disetujui oleh Administrator.'));

        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);

        try {
            $convId = \App\Models\Message::makeConversationId(auth()->id(), $user->id);

            \App\Models\Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $user->id,
                'conversation_id' => $convId,
                'subject' => 'Pendaftaran Akun Ditolak',
                'body' => "Pendaftaran akun Anda ditolak oleh Administrator.",
                'reason' => $reason,
                'message_type' => 'registration_rejected',
                'is_read' => false,
            ]);
        } catch (\Throwable $e) {}

        $this->notifySuccess("Pendaftaran pengguna \"{$user->name}\" berhasil ditolak.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Reject user deactivation request and send notification message to the user.
     */
    public function rejectDeactivation(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $reason = trim($request->input('reason', 'Permohonan penonaktifan tidak disetujui oleh Administrator.'));

        $user->update([
            'deactivation_requested_at' => null,
            'deactivation_reason' => null,
        ]);

        // Kirim pesan ke tabel messages & notifikasi dengan conversation_id
        try {
            $convId = \App\Models\Message::makeConversationId(auth()->id(), $user->id);

            \App\Models\Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $user->id,
                'conversation_id' => $convId,
                'subject' => 'Permohonan Non Aktif Akun Ditolak',
                'body' => "Permohonan penonaktifan akun Anda ditolak oleh Administrator.",
                'reason' => $reason,
                'message_type' => 'deactivation_rejected',
                'is_read' => false,
            ]);

            $user->notifications()->create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'type' => 'deactivation_rejected',
                'data' => [
                    'title' => 'Permohonan Non Aktif Akun Ditolak',
                    'subtitle' => 'Permohonan non aktif akun Anda ditolak oleh Administrator.',
                    'message' => 'Permohonan non aktif akun Anda ditolak oleh Administrator.',
                    'reason' => $reason,
                    'icon' => 'ti ti-user-x',
                    'badge_class' => 'bg-danger-subtle text-danger border-danger-subtle',
                    'badge_label' => 'Penonaktifan Ditolak',
                    'url' => route('admin.profil-pengguna.messages.index', ['user_id' => auth()->id()]),
                ],
                'read_at' => null,
            ]);
        } catch (\Throwable $e) {
            // Silently fallback if notifications table issue
        }

        $this->notifySuccess("Permohonan penonaktifan pengguna \"{$user->name}\" telah ditolak & notifikasi dikirimkan.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Activate user upon reactivation request.
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'active',
            'reactivation_requested_at' => null,
            'reactivation_reason' => null,
        ]);

        $this->notifySuccess("Akun pengguna \"{$user->name}\" berhasil diaktifkan kembali.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Toggle status active / inactive for user.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            $this->notifyError("Anda tidak dapat mengubah status akun Anda sendiri.");
            return redirect()->route('admin.manajemenpengguna.users.index');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $updateData = ['status' => $newStatus];
        if ($newStatus === 'inactive') {
            $updateData['deactivation_requested_at'] = null;
            $updateData['deactivation_reason'] = null;
        } elseif ($newStatus === 'active') {
            $updateData['reactivation_requested_at'] = null;
            $updateData['reactivation_reason'] = null;
        }

        $user->update($updateData);

        $label = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        $this->notifySuccess("Status akun \"{$user->name}\" berhasil {$label}.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Remove the specified user account.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            $this->notifyError("Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.");
            return redirect()->route('admin.manajemenpengguna.users.index');
        }

        if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Pengguna \"{$user->name}\" berhasil dihapus.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Switch / Impersonate to another user account.
     */
    public function switchAccount(Request $request, $id)
    {
        $currentUser = auth()->user();

        // Check authorization
        if (!$currentUser->hasAnyRole(['superadmin', 'admin']) && !$currentUser->can('update manajemenpengguna/users')) {
            $this->notifyError("Anda tidak memiliki izin untuk melakukan switch akun.");
            return redirect()->back();
        }

        // Prevent nested switch
        if (session()->has('impersonator_id')) {
            $this->notifyWarning("Anda sedang dalam mode switch akun. Silakan kembali ke akun utama terlebih dahulu sebelum beralih ke akun lain.");
            return redirect()->back();
        }

        $targetUser = User::findOrFail($id);

        if ($targetUser->id === $currentUser->id) {
            $this->notifyWarning("Anda sudah sedang login pada akun ini.");
            return redirect()->back();
        }

        if ($targetUser->status !== 'active') {
            $this->notifyError("Tidak dapat beralih ke akun yang berstatus tidak aktif atau belum disetujui.");
            return redirect()->back();
        }

        // Store original impersonator data in session
        session([
            'impersonator_id' => $currentUser->id,
            'impersonator_name' => $currentUser->name,
            'impersonator_role' => $currentUser->roles->pluck('name')->implode(', ') ?: 'Administrator',
        ]);

        // Login as target user
        Auth::loginUsingId($targetUser->id);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Berhasil beralih akun. Anda sekarang masuk sebagai \"{$targetUser->name}\".");

        return redirect()->route('dashboard');
    }

    /**
     * Leave impersonation and return to the original user account.
     */
    public function switchBack(Request $request)
    {
        if (!session()->has('impersonator_id')) {
            $this->notifyWarning("Tidak ada sesi switch akun yang aktif.");
            return redirect()->route('dashboard');
        }

        $impersonatorId = session()->pull('impersonator_id');
        session()->forget('impersonator_name');
        session()->forget('impersonator_role');

        $originalUser = User::find($impersonatorId);

        if (!$originalUser) {
            $this->notifyError("Akun utama tidak ditemukan.");
            return redirect()->route('login');
        }

        Auth::loginUsingId($originalUser->id);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Berhasil kembali ke akun utama \"{$originalUser->name}\".");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Bulk assign, append, or remove roles for selected users.
     */
    public function bulkAssignRole(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'action_mode' => 'required|in:sync,append,remove',
        ], [
            'user_ids.required' => 'Pilih minimal satu pengguna untuk diperbarui perannya.',
            'action_mode.required' => 'Pilih mode tindakan perubahan role.',
        ]);

        $userIds = $validated['user_ids'];
        $selectedRoles = $validated['roles'] ?? [];
        $mode = $validated['action_mode'];

        if (empty($selectedRoles) && $mode !== 'sync') {
            $this->notifyWarning('Pilih minimal satu peran (role) untuk mode ini.');
            return redirect()->back();
        }

        $users = User::whereIn('id', $userIds)->get();
        $updatedCount = 0;

        foreach ($users as $user) {
            if ($mode === 'sync') {
                $user->syncRoles($selectedRoles);
                $updatedCount++;
            } elseif ($mode === 'append') {
                if (!empty($selectedRoles)) {
                    $user->assignRole($selectedRoles);
                    $updatedCount++;
                }
            } elseif ($mode === 'remove') {
                foreach ($selectedRoles as $roleName) {
                    if ($user->hasRole($roleName)) {
                        $user->removeRole($roleName);
                    }
                }
                $updatedCount++;
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $actionText = match ($mode) {
            'sync' => 'disinkronisasi / diatur ulang',
            'append' => 'ditambahkan',
            'remove' => 'dicabut',
        };

        $this->notifySuccess("Peran (Role) berhasil {$actionText} untuk {$updatedCount} pengguna terpilih.");

        return redirect()->route('admin.manajemenpengguna.users.index');
    }

    /**
     * Download format Excel minimal untuk import data pengguna.
     */
    public function downloadTemplateExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pengguna');

        // Header Titles
        $headers = [
            'A1' => 'Nama Lengkap *',
            'B1' => 'Email *',
            'C1' => 'Password (Default: password*)',
            'D1' => 'Role (Default: user)',
            'E1' => 'Status (active / pending / inactive)',
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Header Styling
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E293B'], // Slate 800
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'CBD5E1'],
                ],
            ],
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Sample Data Rows (Hanya 3 baris contoh murni tanpa teks catatan di bawahnya)
        $sampleData = [
            ['Ahmad Fadillah', 'ahmad.fadillah@example.com', 'password*', 'user', 'active'],
            ['Siti Rahmawati', 'siti.rahmawati@example.com', 'password*', 'user', 'active'],
            ['Budi Hartono', 'budi.hartono@example.com', 'password*', 'user', 'active'],
        ];

        $rowIdx = 2;
        foreach ($sampleData as $row) {
            $sheet->setCellValue('A' . $rowIdx, $row[0]);
            $sheet->setCellValue('B' . $rowIdx, $row[1]);
            $sheet->setCellValueExplicit('C' . $rowIdx, $row[2], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowIdx, $row[3]);
            $sheet->setCellValue('E' . $rowIdx, $row[4]);

            $sheet->getStyle("A{$rowIdx}:E{$rowIdx}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('E2E8F0');
            $sheet->getStyle("C{$rowIdx}:E{$rowIdx}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($rowIdx)->setRowHeight(22);
            $rowIdx++;
        }

        // Auto-fit column widths
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'format_upload_users.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Import users from uploaded Excel file (.xlsx, .xls, .csv).
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
            'duplicate_action' => 'required|in:skip,update',
        ], [
            'excel_file.required' => 'Silakan pilih berkas Excel atau CSV terlebih dahulu.',
            'excel_file.mimes' => 'Berkas harus berupa format .xlsx, .xls, atau .csv.',
            'excel_file.max' => 'Ukuran berkas maksimal 5MB.',
        ]);

        $file = $request->file('excel_file');
        $duplicateAction = $request->input('duplicate_action', 'skip');

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Throwable $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal membaca berkas Excel: ' . $e->getMessage()
                ], 422);
            }
            $this->notifyError('Gagal membaca berkas Excel: ' . $e->getMessage());
            return redirect()->back();
        }

        if (count($rows) <= 1) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Berkas Excel kosong atau tidak memiliki data pengguna.'
                ], 422);
            }
            $this->notifyWarning('Berkas Excel kosong atau tidak memiliki data pengguna.');
            return redirect()->back();
        }

        // Pastikan role 'user' tersedia
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $existingRoles = Role::pluck('name')->toArray();

        $successCount = 0;
        $updatedCount = 0;
        $duplicateSkipCount = 0;
        $invalidCount = 0;

        // Skip header (row 1), process data rows
        $isFirst = true;
        foreach ($rows as $rowIndex => $row) {
            if ($isFirst) {
                $isFirst = false;
                continue;
            }

            $name = trim((string) ($row['A'] ?? ''));
            $email = strtolower(trim((string) ($row['B'] ?? '')));
            $password = trim((string) ($row['C'] ?? ''));
            $roleInput = trim((string) ($row['D'] ?? ''));
            $statusInput = strtolower(trim((string) ($row['E'] ?? '')));

            // Abaikan baris kosong total
            if (empty($name) && empty($email) && empty($password) && empty($roleInput) && empty($statusInput)) {
                continue;
            }

            // Abaikan baris teks petunjuk atau catatan (jika ada teks petunjuk di kolom A tanpa email)
            if (empty($email) && (
                str_starts_with(strtoupper($name), 'PETUNJUK') ||
                preg_match('/^[0-9]+\.\s*/', $name) ||
                str_contains(strtolower($name), 'wajib') ||
                str_contains(strtolower($name), 'kolom')
            )) {
                continue;
            }

            // Jika email kosong padahal ada nama atau sebaliknya
            if (empty($name) || empty($email)) {
                $invalidCount++;
                continue;
            }

            // Validasi format email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $invalidCount++;
                continue;
            }

            // Normalisasi Role
            $roleName = !empty($roleInput) ? strtolower($roleInput) : 'user';
            $rolesToAssign = array_filter(array_map('trim', explode(',', $roleName)));
            if (empty($rolesToAssign)) {
                $rolesToAssign = ['user'];
            }

            $validRoles = [];
            foreach ($rolesToAssign as $r) {
                if (in_array($r, $existingRoles)) {
                    $validRoles[] = $r;
                } else {
                    $createdRole = Role::firstOrCreate(['name' => $r, 'guard_name' => 'web']);
                    $existingRoles[] = $r;
                    $validRoles[] = $r;
                }
            }
            if (empty($validRoles)) {
                $validRoles = ['user'];
            }

            // Normalisasi Status & Password
            $status = in_array($statusInput, ['active', 'pending', 'inactive']) ? $statusInput : 'active';
            $passwordVal = !empty($password) ? $password : 'password*';

            // Cek apakah pengguna sudah terdaftar di database
            $existingUser = User::where('email', $email)->first();

            if ($existingUser) {
                if ($duplicateAction === 'skip') {
                    $duplicateSkipCount++;
                    continue;
                } elseif ($duplicateAction === 'update') {
                    $updatePayload = [
                        'name' => $name,
                        'status' => $status,
                    ];
                    if (!empty($password)) {
                        $updatePayload['password'] = Hash::make($password);
                    }
                    if ($status === 'active' && $existingUser->status === 'pending') {
                        $updatePayload['approved_at'] = now();
                        $updatePayload['approved_by'] = auth()->id();
                    }
                    $existingUser->update($updatePayload);
                    $existingUser->syncRoles($validRoles);
                    $updatedCount++;
                    continue;
                }
            }

            // Buat akun pengguna baru
            $newUser = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($passwordVal),
                'status' => $status,
                'approved_at' => $status === 'active' ? now() : null,
                'approved_by' => $status === 'active' ? auth()->id() : null,
            ]);

            $newUser->syncRoles($validRoles);
            $successCount++;
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $messageParts = [];
        if ($successCount > 0) {
            $messageParts[] = "{$successCount} pengguna baru berhasil ditambahkan";
        }
        if ($updatedCount > 0) {
            $messageParts[] = "{$updatedCount} data pengguna diperbarui";
        }
        if ($duplicateSkipCount > 0) {
            $messageParts[] = "{$duplicateSkipCount} pengguna dilewati (email sudah terdaftar)";
        }
        if ($invalidCount > 0) {
            $messageParts[] = "{$invalidCount} baris tidak valid (nama/email kosong atau salah format)";
        }

        $resultMsg = !empty($messageParts) ? implode(', ', $messageParts) . '.' : 'Tidak ada data pengguna yang diproses.';

        // Support AJAX Response
        if ($request->ajax() || $request->wantsJson()) {
            if ($successCount > 0 || $updatedCount > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => "Import Selesai: {$resultMsg}",
                    'data' => [
                        'success_count' => $successCount,
                        'updated_count' => $updatedCount,
                        'duplicate_skip_count' => $duplicateSkipCount,
                        'invalid_count' => $invalidCount,
                    ]
                ], 200);
            } elseif ($duplicateSkipCount > 0) {
                return response()->json([
                    'status' => 'warning',
                    'message' => "Import Selesai: {$resultMsg}",
                    'data' => [
                        'success_count' => $successCount,
                        'updated_count' => $updatedCount,
                        'duplicate_skip_count' => $duplicateSkipCount,
                        'invalid_count' => $invalidCount,
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "Gagal Memproses Data: {$resultMsg}",
                    'data' => [
                        'success_count' => $successCount,
                        'updated_count' => $updatedCount,
                        'duplicate_skip_count' => $duplicateSkipCount,
                        'invalid_count' => $invalidCount,
                    ]
                ], 422);
            }
        }

        if ($successCount > 0 || $updatedCount > 0) {
            $this->notifySuccess("Import Selesai: {$resultMsg}");
        } elseif ($duplicateSkipCount > 0) {
            $this->notifyWarning("Import Selesai: {$resultMsg}");
        } else {
            $this->notifyError("Gagal Memproses Data: {$resultMsg}");
        }

        return redirect()->route('admin.manajemenpengguna.users.index');
    }
}
