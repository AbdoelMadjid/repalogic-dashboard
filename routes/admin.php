<?php

use App\Http\Controllers\Admin\DukunganAplikasi\MenuController;
use App\Http\Controllers\Admin\DukunganAplikasi\ProfilAplikasiController;
use App\Http\Controllers\Admin\ManajemenPengguna\AksesRoleController;
use App\Http\Controllers\Admin\ManajemenPengguna\AksesUserController;
use App\Http\Controllers\Admin\ManajemenPengguna\PermissionController;
use App\Http\Controllers\Admin\ManajemenPengguna\RoleController;
use App\Http\Controllers\Admin\ManajemenPengguna\UserController;
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
    Route::prefix('dukunganaplikasi')->name('dukunganaplikasi.')->group(function () {
        Route::get('profil-aplikasi', [ProfilAplikasiController::class, 'index'])->name('profil-aplikasi.index');
        Route::post('profil-aplikasi', [ProfilAplikasiController::class, 'update'])->name('profil-aplikasi.update');

        Route::post('menu/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggle-status');
        Route::post('menu/reorder', [MenuController::class, 'reorder'])->name('menu.reorder');
        Route::resource('menu', MenuController::class);
    });

    Route::prefix('manajemenpengguna')->name('manajemenpengguna.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('akses-role', AksesRoleController::class);
        Route::resource('akses-user', AksesUserController::class);
    });
});
