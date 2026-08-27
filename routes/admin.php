<?php

use App\Http\Controllers\Admin\DukunganAplikasi\BackupDbController;
use App\Http\Controllers\Admin\DukunganAplikasi\FiturAplikasiController;
use App\Http\Controllers\Admin\DukunganAplikasi\KonfigurasiWebsiteController;
use App\Http\Controllers\Admin\DukunganAplikasi\MenuController;
use App\Http\Controllers\Admin\DukunganAplikasi\ProfilAplikasiController;
use App\Http\Controllers\Admin\DukunganAplikasi\TranslationController;
use App\Http\Controllers\Admin\ManajemenPengguna\AksesRoleController;
use App\Http\Controllers\Admin\ManajemenPengguna\AksesUserController;
use App\Http\Controllers\Admin\ManajemenPengguna\PermissionController;
use App\Http\Controllers\Admin\ManajemenPengguna\RoleController;
use App\Http\Controllers\Admin\ManajemenPengguna\UserController;
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
    Route::get('profil-pengguna', [ProfilPenggunaController::class, 'index'])->name('profil-pengguna.index');
    Route::post('profil-pengguna/update-quick', [ProfilPenggunaController::class, 'updateQuick'])->name('profil-pengguna.update-quick');
    Route::get('profil-pengguna/edit', [ProfilPenggunaController::class, 'edit'])->name('profil-pengguna.edit');
    Route::post('profil-pengguna/update-detail', [ProfilPenggunaController::class, 'updateDetail'])->name('profil-pengguna.update-detail');
    Route::post('profil-pengguna/update-cover', [ProfilPenggunaController::class, 'updateCover'])->name('profil-pengguna.update-cover');
    Route::post('profil-pengguna/update-motto', [ProfilPenggunaController::class, 'updateMotto'])->name('profil-pengguna.update-motto');

    Route::prefix('dukunganaplikasi')->name('dukunganaplikasi.')->group(function () {
        Route::get('profil-aplikasi', [ProfilAplikasiController::class, 'index'])->name('profil-aplikasi.index');
        Route::post('profil-aplikasi', [ProfilAplikasiController::class, 'update'])->name('profil-aplikasi.update');

        Route::get('fitur-aplikasi', [FiturAplikasiController::class, 'index'])->name('fitur-aplikasi.index');
        Route::post('fitur-aplikasi/toggle', [FiturAplikasiController::class, 'toggleFeature'])->name('fitur-aplikasi.toggle');
        Route::post('fitur-aplikasi/toggle-group', [FiturAplikasiController::class, 'toggleGroup'])->name('fitur-aplikasi.toggle-group');
        Route::post('fitur-aplikasi', [FiturAplikasiController::class, 'update'])->name('fitur-aplikasi.update');

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
        Route::resource('users', UserController::class);
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('akses-role', AksesRoleController::class);
        Route::resource('akses-user', AksesUserController::class);
    });
});
