<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DukunganAplikasi\BackupDbController;
use App\Http\Controllers\Admin\DukunganAplikasi\FiturAplikasiController;
use App\Http\Controllers\Admin\DukunganAplikasi\KonfigurasiWebsiteController;
use App\Http\Controllers\Admin\DukunganAplikasi\MenuController;
use App\Http\Controllers\Admin\DukunganAplikasi\ProfilAplikasiController;
use App\Http\Controllers\Admin\DukunganAplikasi\TranslationController;
use App\Http\Controllers\Admin\FriendshipController;
use App\Http\Controllers\Admin\ManajemenPengguna\AksesRoleController;
use App\Http\Controllers\Admin\ManajemenPengguna\AksesUserController;
use App\Http\Controllers\Admin\ManajemenPengguna\DataLoginController;
use App\Http\Controllers\Admin\ManajemenPengguna\PermissionController;
use App\Http\Controllers\Admin\ManajemenPengguna\RoleController;
use App\Http\Controllers\Admin\ManajemenPengguna\UserController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfilPenggunaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Module Routes
|--------------------------------------------------------------------------
|
| Separated route definitions for Admin Modules & System Management.
|
*/

Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('notifications/poll', [NotificationController::class, 'poll'])->name('notifications.poll');
    Route::get('notifications/poll-messages', [NotificationController::class, 'pollMessages'])->name('notifications.poll-messages');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');

    Route::post('switch-back', [UserController::class, 'switchBack'])->name('switch-back');

    Route::prefix('profil-pengguna')->name('profil-pengguna.')->group(function () {
        Route::get('/', [ProfilPenggunaController::class, 'index'])->name('index');
        Route::post('update-quick', [ProfilPenggunaController::class, 'updateQuick'])->name('update-quick');
        Route::post('update-detail', [ProfilPenggunaController::class, 'updateDetail'])->name('update-detail');
        Route::post('update-cover', [ProfilPenggunaController::class, 'updateCover'])->name('update-cover');
        Route::post('update-motto', [ProfilPenggunaController::class, 'updateMotto'])->name('update-motto');
        Route::post('request-deactivation', [ProfilPenggunaController::class, 'requestDeactivation'])->name('request-deactivation');
        Route::post('cancel-deactivation', [ProfilPenggunaController::class, 'cancelDeactivation'])->name('cancel-deactivation');

        // Fitur Pesan & Obrolan (admin/profil-pengguna/messages)
        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/poll-contacts', [MessageController::class, 'pollContacts'])->name('messages.poll-contacts');
        Route::get('messages/conversation/{user}', [MessageController::class, 'getMessages'])->name('messages.conversation');
        Route::post('messages/send', [MessageController::class, 'send'])->name('messages.send');
        Route::post('messages/{id}/toggle-pin', [MessageController::class, 'togglePin'])->whereNumber('id')->name('messages.toggle-pin');
        Route::post('messages/{id}/toggle-reaction', [MessageController::class, 'toggleReaction'])->whereNumber('id')->name('messages.toggle-reaction');
        Route::post('messages/{id}/forward', [MessageController::class, 'forward'])->whereNumber('id')->name('messages.forward');
        Route::delete('messages/conversation/{user}/clear', [MessageController::class, 'clearConversation'])->name('messages.clear-conversation');
        Route::delete('messages/{id}', [MessageController::class, 'destroy'])->whereNumber('id')->name('messages.destroy');
    });

    // Fitur Pertemanan & Like Profil (admin/friendships)
    Route::prefix('friendships')->name('friendships.')->group(function () {
        Route::get('poll-dashboard', [FriendshipController::class, 'pollDashboard'])->name('poll-dashboard');
        Route::post('toggle-like/{user}', [FriendshipController::class, 'toggleLike'])->name('toggle-like');
        Route::post('send/{user}', [FriendshipController::class, 'sendRequest'])->name('send');
        Route::post('accept/{id}', [FriendshipController::class, 'acceptRequest'])->whereNumber('id')->name('accept');
        Route::post('reject/{id}', [FriendshipController::class, 'rejectRequest'])->whereNumber('id')->name('reject');
        Route::post('cancel/{user}', [FriendshipController::class, 'cancelRequest'])->name('cancel');
        Route::delete('unfriend/{user}', [FriendshipController::class, 'unfriend'])->name('unfriend');
    });

    Route::prefix('dukunganaplikasi')->name('dukunganaplikasi.')->group(function () {
        Route::get('profil-aplikasi', [ProfilAplikasiController::class, 'index'])->name('profil-aplikasi.index');
        Route::post('profil-aplikasi', [ProfilAplikasiController::class, 'update'])->name('profil-aplikasi.update');

        Route::get('fitur-aplikasi', [FiturAplikasiController::class, 'index'])->name('fitur-aplikasi.index');
        Route::post('fitur-aplikasi', [FiturAplikasiController::class, 'store'])->name('fitur-aplikasi.store');
        Route::post('fitur-aplikasi/toggle', [FiturAplikasiController::class, 'toggleFeature'])->name('fitur-aplikasi.toggle');
        Route::post('fitur-aplikasi/toggle-group', [FiturAplikasiController::class, 'toggleGroup'])->name('fitur-aplikasi.toggle-group');
        Route::post('fitur-aplikasi/bulk-action', [FiturAplikasiController::class, 'bulkAction'])->name('fitur-aplikasi.bulk-action');
        Route::post('fitur-aplikasi/clear-cache', [FiturAplikasiController::class, 'clearSystemCache'])->name('fitur-aplikasi.clear-cache');
        Route::post('fitur-aplikasi/update-setting', [FiturAplikasiController::class, 'updateAppSetting'])->name('fitur-aplikasi.update-setting');
        Route::match(['post', 'put', 'patch'], 'fitur-aplikasi/{id}', [FiturAplikasiController::class, 'update'])->whereNumber('id')->name('fitur-aplikasi.update');
        Route::delete('fitur-aplikasi/{id}', [FiturAplikasiController::class, 'destroy'])->whereNumber('id')->name('fitur-aplikasi.destroy');

        Route::post('menu/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggle-status');
        Route::post('menu/reorder', [MenuController::class, 'reorder'])->name('menu.reorder');
        Route::resource('menu', MenuController::class);
        Route::resource('translation', TranslationController::class);

        Route::get('backup-db', [BackupDbController::class, 'index'])->name('backup-db.index');
        Route::post('backup-db/process', [BackupDbController::class, 'processBackup'])->name('backup-db.process');
        Route::get('backup-db/download/{filename}', [BackupDbController::class, 'download'])->name('backup-db.download');
        Route::delete('backup-db/destroy/{filename}', [BackupDbController::class, 'destroy'])->name('backup-db.destroy');

        Route::get('konfigurasi-website', [KonfigurasiWebsiteController::class, 'index'])->name('konfigurasi-website.index');
        Route::post('konfigurasi-website/store-theme', [KonfigurasiWebsiteController::class, 'storeTheme'])->name('konfigurasi-website.store-theme');
        Route::post('konfigurasi-website/activate-theme/{id}', [KonfigurasiWebsiteController::class, 'activateTheme'])->name('konfigurasi-website.activate-theme');
        Route::post('konfigurasi-website/store-section', [KonfigurasiWebsiteController::class, 'storeSection'])->name('konfigurasi-website.store-section');
        Route::match(['POST', 'PUT'], 'konfigurasi-website/update-section/{id}', [KonfigurasiWebsiteController::class, 'updateSection'])->name('konfigurasi-website.update-section');
        Route::delete('konfigurasi-website/destroy-section/{id}', [KonfigurasiWebsiteController::class, 'destroySection'])->name('konfigurasi-website.destroy-section');
        Route::post('konfigurasi-website/toggle-active-section/{id}', [KonfigurasiWebsiteController::class, 'toggleActiveSection'])->name('konfigurasi-website.toggle-active-section');
        Route::post('konfigurasi-website/update-section-position/{id}', [KonfigurasiWebsiteController::class, 'updateSectionPosition'])->name('konfigurasi-website.update-section-position');
        Route::post('konfigurasi-website/reorder-sections', [KonfigurasiWebsiteController::class, 'reorderSections'])->name('konfigurasi-website.reorder-sections');
    });

    Route::prefix('manajemenpengguna')->name('manajemenpengguna.')->group(function () {
        Route::post('users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::post('users/{id}/reject-registration', [UserController::class, 'rejectRegistration'])->name('users.reject-registration');
        Route::post('users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::post('users/{id}/reject-deactivation', [UserController::class, 'rejectDeactivation'])->name('users.reject-deactivation');
        Route::post('users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::post('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('users/{id}/switch-account', [UserController::class, 'switchAccount'])->name('users.switch-account');
        Route::post('users/bulk-assign-role', [UserController::class, 'bulkAssignRole'])->name('users.bulk-assign-role');
        Route::resource('users', UserController::class);
        Route::post('data-login/clear', [DataLoginController::class, 'clearOldLogs'])->name('data-login.clear');
        Route::get('data-login/{id}', [DataLoginController::class, 'show'])->whereNumber('id')->name('data-login.show');
        Route::delete('data-login/{id}', [DataLoginController::class, 'destroy'])->whereNumber('id')->name('data-login.destroy');
        Route::get('data-login', [DataLoginController::class, 'index'])->name('data-login.index');

        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('akses-role', AksesRoleController::class);
        Route::resource('akses-user', AksesUserController::class);
    });
});
