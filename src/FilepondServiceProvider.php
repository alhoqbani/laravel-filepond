<?php

namespace Alhoqbani\Filepond;

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
    }
}
