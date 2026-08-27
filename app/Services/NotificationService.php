<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Get aggregated system notifications for topbar dropdown.
     * Supports:
     * - Registration approvals (Pendaftaran Mandiri)
     * - User deactivation requests (Permintaan Nonaktif User)
     * - Password reset requests (Permintaan Reset Password)
     * - Chat / User Messages (Pesan Baru Antar Pengguna)
     * - Database / System notifications
     */
    public static function getNotifications(?User $currentUser = null): array
    {
        $user = $currentUser ?: Auth::user();
        if (!$user) {
            return [
                'items' => collect(),
                'total_count' => 0,
                'unread_count' => 0,
                'categories' => [],
            ];
        }

        $items = collect();
        $canManageUsers = $user->hasRole(['superadmin', 'admin']) ||
            $user->can('read manajemenpengguna/users') ||
            $user->can('update manajemenpengguna/users');

        // 1. Pendaftaran Pengguna Mandiri (Self-Registration Approval)
        if ($canManageUsers) {
            $pendingUsers = User::where('status', 'pending')
                ->latest()
                ->take(10)
                ->get();

            foreach ($pendingUsers as $pUser) {
                $items->push([
                    'id' => 'registration-' . $pUser->id,
                    'type' => 'registration',
                    'category_label' => 'Pendaftaran Akun',
                    'title' => $pUser->name,
                    'subtitle' => $pUser->email,
                    'message' => 'Pendaftaran akun baru menunggu persetujuan administrator.',
                    'avatar' => $pUser->avatar_url,
                    'icon' => 'ti ti-user-plus',
                    'badge_class' => 'bg-warning-subtle text-warning border-warning-subtle',
                    'badge_label' => 'Perlu Persetujuan',
                    'url' => route('admin.manajemenpengguna.users.index', ['search' => $pUser->name]),
                    'created_at' => $pUser->created_at,
                    'time_ago' => $pUser->created_at ? $pUser->created_at->diffForHumans() : 'Baru saja',
                    'is_unread' => true,
                ]);
            }
        }

        // 2. Permintaan Reset Password (Password Reset Request)
        if ($canManageUsers) {
            $resetRequestedUsers = User::whereNotNull('password_reset_requested_at')
                ->latest('password_reset_requested_at')
                ->take(10)
                ->get();

            foreach ($resetRequestedUsers as $rUser) {
                $items->push([
                    'id' => 'reset-password-' . $rUser->id,
                    'type' => 'reset_password_request',
                    'category_label' => 'Reset Password',
                    'title' => $rUser->name,
                    'subtitle' => $rUser->email,
                    'message' => 'Mengajukan permintaan reset kata sandi ke password standar.',
                    'avatar' => $rUser->avatar_url,
                    'icon' => 'ti ti-key',
                    'badge_class' => 'bg-info-subtle text-info border-info-subtle',
                    'badge_label' => 'Minta Reset',
                    'url' => route('admin.manajemenpengguna.users.index', ['search' => $rUser->name]),
                    'created_at' => $rUser->password_reset_requested_at,
                    'time_ago' => $rUser->password_reset_requested_at ? $rUser->password_reset_requested_at->diffForHumans() : 'Baru saja',
                    'is_unread' => true,
                ]);
            }
        }

        // 3. Permintaan Nonaktifkan Akun Pengguna (Account Deactivation Request)
        if ($canManageUsers) {
            $deactivationRequestedUsers = User::whereNotNull('deactivation_requested_at')
                ->latest('deactivation_requested_at')
                ->take(10)
                ->get();

            foreach ($deactivationRequestedUsers as $dUser) {
                $items->push([
                    'id' => 'deactivation-' . $dUser->id,
                    'type' => 'deactivate_request',
                    'category_label' => 'Nonaktif Akun',
                    'title' => $dUser->name,
                    'subtitle' => $dUser->email,
                    'message' => 'Mengajukan permohonan penonaktifan akun' . ($dUser->deactivation_reason ? ': ' . $dUser->deactivation_reason : '.'),
                    'avatar' => $dUser->avatar_url,
                    'icon' => 'ti ti-user-x',
                    'badge_class' => 'bg-danger-subtle text-danger border-danger-subtle',
                    'badge_label' => 'Minta Nonaktif',
                    'url' => route('admin.manajemenpengguna.users.index', ['search' => $dUser->name]),
                    'created_at' => $dUser->deactivation_requested_at,
                    'time_ago' => $dUser->deactivation_requested_at ? $dUser->deactivation_requested_at->diffForHumans() : 'Baru saja',
                    'is_unread' => true,
                ]);
            }
        }

        // 4. Permintaan Aktivasi Kembali Akun Pengguna (Account Reactivation Request)
        if ($canManageUsers) {
            $reactivationRequestedUsers = User::whereNotNull('reactivation_requested_at')
                ->latest('reactivation_requested_at')
                ->take(10)
                ->get();

            foreach ($reactivationRequestedUsers as $actUser) {
                $items->push([
                    'id' => 'reactivation-' . $actUser->id,
                    'type' => 'activation_request',
                    'category_label' => 'Aktivasi Akun',
                    'title' => $actUser->name,
                    'subtitle' => $actUser->email,
                    'message' => 'Mengajukan permohonan pengaktifan kembali akun' . ($actUser->reactivation_reason ? ': ' . $actUser->reactivation_reason : '.'),
                    'avatar' => $actUser->avatar_url,
                    'icon' => 'ti ti-user-check',
                    'badge_class' => 'bg-success-subtle text-success border-success-subtle',
                    'badge_label' => 'Minta Aktivasi',
                    'url' => route('admin.manajemenpengguna.users.index', ['search' => $actUser->name]),
                    'created_at' => $actUser->reactivation_requested_at,
                    'time_ago' => $actUser->reactivation_requested_at ? $actUser->reactivation_requested_at->diffForHumans() : 'Baru saja',
                    'is_unread' => true,
                ]);
            }
        }

        // 5. Database Notifications (Standar Laravel Notifications jika tabel ada)
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('notifications') && method_exists($user, 'unreadNotifications')) {
                $dbNotifications = $user->unreadNotifications()->take(10)->get();
                foreach ($dbNotifications as $dNotif) {
                    $data = $dNotif->data;
                    $notifType = $data['type'] ?? 'system';

                    $items->push([
                        'id' => 'db-' . $dNotif->id,
                        'type' => $notifType,
                        'category_label' => $data['category_label'] ?? 'Pemberitahuan',
                        'title' => $data['title'] ?? 'Notifikasi Sistem',
                        'subtitle' => $data['subtitle'] ?? null,
                        'message' => $data['message'] ?? 'Ada pembaruan aktivitas pada sistem.',
                        'avatar' => $data['avatar'] ?? asset('assets/images/users/default-avatar.svg'),
                        'icon' => $data['icon'] ?? 'ti ti-bell-ringing',
                        'badge_class' => $data['badge_class'] ?? 'bg-info-subtle text-info border-info-subtle',
                        'badge_label' => $data['badge_label'] ?? 'Info',
                        'url' => $data['url'] ?? 'javascript:void(0);',
                        'created_at' => $dNotif->created_at,
                        'time_ago' => $dNotif->created_at ? $dNotif->created_at->diffForHumans() : 'Baru saja',
                        'is_unread' => is_null($dNotif->read_at),
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // Silently fallback if notifications table is inaccessible
        }

        // Urutkan seluruh notifikasi berdasarkan waktu terbaru
        $sortedItems = $items->sortByDesc('created_at')->values();

        // Hitung kategori notifikasi
        $categories = [
            'registration' => $sortedItems->where('type', 'registration')->count(),
            'deactivate_request' => $sortedItems->where('type', 'deactivate_request')->count(),
            'reset_password_request' => $sortedItems->where('type', 'reset_password_request')->count(),
            'chat_message' => $sortedItems->where('type', 'chat_message')->count(),
            'system' => $sortedItems->where('type', 'system')->count(),
        ];

        return [
            'items' => $sortedItems,
            'total_count' => $sortedItems->count(),
            'unread_count' => $sortedItems->where('is_unread', true)->count(),
            'categories' => $categories,
        ];
    }
}
