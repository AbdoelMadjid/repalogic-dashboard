<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Template Dynamic Routes
|--------------------------------------------------------------------------
|
| Automatically registers named routes for all demo Blade view templates
| located under resources/views/template/ according to their directory hierarchy.
|
*/

Route::prefix('template')->name('template.')->middleware(['web'])->group(function () {
    $templatePath = resource_path('views/template');

    if (file_exists($templatePath)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($templatePath, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php' && str_ends_with($file->getFilename(), '.blade.php')) {
                // Get relative path from resources/views/template
                $relativePath = substr($file->getPathname(), strlen($templatePath) + 1);
                $cleanPath = str_replace('.blade.php', '', $relativePath);
                $normalizedPath = str_replace('\\', '/', $cleanPath);
                $viewDotName = str_replace('/', '.', $normalizedPath);

                // Register primary route matching view hierarchy
                Route::get($normalizedPath, function () use ($viewDotName) {
                    return view("template.{$viewDotName}");
                })->name($viewDotName);

                // If under custom/, also register custom-pages alias route
                if (str_starts_with($normalizedPath, 'custom/')) {
                    $aliasPath = 'custom-pages/' . substr($normalizedPath, 7);
                    $aliasDotName = 'custom-pages.' . substr($viewDotName, 7);

                    Route::get($aliasPath, function () use ($viewDotName) {
                        return view("template.{$viewDotName}");
                    })->name($aliasDotName);
                }

                // Check if filename has redundant parent directory prefix (e.g., basic/basic-sign-in)
                $pathParts = explode('/', $normalizedPath);
                $filenamePart = array_pop($pathParts);
                $parentDirPart = end($pathParts);

                if ($parentDirPart && str_starts_with($filenamePart, $parentDirPart . '-')) {
                    $cleanFilenamePart = substr($filenamePart, strlen($parentDirPart) + 1);
                    $cleanNormalizedPath = implode('/', $pathParts) . '/' . $cleanFilenamePart;
                    $cleanViewDotName = str_replace('/', '.', $cleanNormalizedPath);

                    Route::get($cleanNormalizedPath, function () use ($viewDotName) {
                        return view("template.{$viewDotName}");
                    })->name($cleanViewDotName);

                    if (str_starts_with($cleanNormalizedPath, 'custom/')) {
                        $aliasPath = 'custom-pages/' . substr($cleanNormalizedPath, 7);
                        $aliasDotName = 'custom-pages.' . substr($cleanViewDotName, 7);

                        Route::get($aliasPath, function () use ($viewDotName) {
                            return view("template.{$viewDotName}");
                        })->name($aliasDotName);
                    }
                }
            }
        }
    }
});
