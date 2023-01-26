<?php

namespace Alhoqbani\Filepond;

use Alhoqbani\Filepond\Http\Controllers\FilepondUploadController;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Alhoqbani\Filepond\Commands\FilepondCommand;

class FilepondServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-filepond')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-filepond_table')
            ->hasCommand(FilepondCommand::class);

        $this->registerRouteMacro();
    }

    public function registerRouteMacro()
    {
        Route::macro('filepond', function (string $baseUrl = 'filepond') {
            Route::prefix($baseUrl)->group(function () {
                Route::post('/upload', [FilepondUploadController::class, 'store']);
            });
        });
    }
}
