<?php

use App\Http\Controllers\Website\EducationController;
use App\Models\Admin\DukunganAplikasi\WebsiteTheme;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Education Portal Website Routes
|--------------------------------------------------------------------------
|
| Rute khusus untuk tema portal Education (Multi-Page Website Theme).
| Menyediakan named routes resmi, direct top-level URLs, serta smart redirect
| handler untuk URL legacy berformat *.blade.php / *.html.
|
*/

// Group Canonical Named Routes: route('education.*')
Route::prefix('education')->name('education.')->group(function () {
    Route::get('/', [EducationController::class, 'index'])->name('home');
    Route::get('/programs', [EducationController::class, 'programs'])->name('programs');
    Route::get('/future-students', [EducationController::class, 'futureStudents'])->name('future-students');
    Route::get('/current-students', [EducationController::class, 'currentStudents'])->name('current-students');
    Route::get('/faculty-and-staff', [EducationController::class, 'facultyAndStaff'])->name('faculty-and-staff');
    Route::get('/faculty-staff', [EducationController::class, 'facultyAndStaff'])->name('faculty-staff');
    Route::get('/events', [EducationController::class, 'events'])->name('events');
    Route::get('/alumni', [EducationController::class, 'alumni'])->name('alumni');
    Route::get('/campus-life', [EducationController::class, 'campusLife'])->name('campus-life');
    Route::get('/research', [EducationController::class, 'research'])->name('research');
    Route::get('/apply', [EducationController::class, 'apply'])->name('apply');
    Route::get('/contacts', [EducationController::class, 'contacts'])->name('contacts');
    Route::get('/help', [EducationController::class, 'help'])->name('help');
    Route::get('/blog-detail', [EducationController::class, 'blogDetail'])->name('blog-detail');
});

// Direct Top-Level Route Aliases
Route::get('/programs', [EducationController::class, 'programs']);
Route::get('/future-students', [EducationController::class, 'futureStudents']);
Route::get('/current-students', [EducationController::class, 'currentStudents']);
Route::get('/faculty-and-staff', [EducationController::class, 'facultyAndStaff']);
Route::get('/faculty-staff', [EducationController::class, 'facultyAndStaff']);
Route::get('/events', [EducationController::class, 'events']);
Route::get('/alumni', [EducationController::class, 'alumni']);
Route::get('/campus-life', [EducationController::class, 'campusLife']);
Route::get('/research', [EducationController::class, 'research']);
Route::get('/apply', [EducationController::class, 'apply']);
Route::get('/contacts', [EducationController::class, 'contacts']);
Route::get('/help', [EducationController::class, 'help']);

// Smart Fallback & Legacy URL Auto-Redirect Handler (e.g. /page-programs-1.blade.php or /page-programs-1.html)
Route::get('/{page}', function ($page) {
    $legacyMap = [
        'page-programs-1' => 'education.programs',
        'page-future-students-1' => 'education.future-students',
        'page-current-students-1' => 'education.current-students',
        'page-faculty-and-staff-1' => 'education.faculty-and-staff',
        'page-faculty-staff-1' => 'education.faculty-and-staff',
        'page-events-1' => 'education.events',
        'page-alumni-1' => 'education.alumni',
        'page-campus-life-1' => 'education.campus-life',
        'page-research-1' => 'education.research',
        'page-apply-1' => 'education.apply',
        'page-contacts-1' => 'education.contacts',
        'page-help-1' => 'education.help',
        'page-signin-1' => 'login',
        'page-blog-single-item-1' => 'education.blog-detail',
        'home-page-1' => 'education.home',
    ];

    $cleanKey = str_replace(['.blade.php', '.html', '.php'], '', $page);

    if (isset($legacyMap[$cleanKey])) {
        return redirect()->route($legacyMap[$cleanKey]);
    }

    $activeTheme = WebsiteTheme::getActiveTheme();
    $folder = $activeTheme->folder ?? 'education';

    if (view()->exists("website.{$folder}.{$cleanKey}")) {
        return view("website.{$folder}.{$cleanKey}");
    }

    abort(404);
})->where('page', '^[a-zA-Z0-9\-_]+(\.(blade\.php|html|php))?$');
