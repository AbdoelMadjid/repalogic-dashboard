<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/template.php';

// Dynamic route handler for website multipage pages (e.g. page-programs-1.blade.php)
Route::get('/{page}', function ($page) {
    $activeTheme = \App\Models\Admin\DukunganAplikasi\WebsiteTheme::getActiveTheme();
    $folder = $activeTheme->folder ?? 'education';
    $cleanPage = str_replace('.blade.php', '', $page);

    if (view()->exists("website.{$folder}.{$cleanPage}")) {
        return view("website.{$folder}.{$cleanPage}");
    }

    abort(404);
})->where('page', '^[a-zA-Z0-9\-_]+(\.blade\.php)?$');
