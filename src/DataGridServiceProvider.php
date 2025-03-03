<?php

namespace Strucura\DataGrid;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Strucura\DataGrid\Actions\RegisterDataGridRoutesAction;
use Strucura\DataGrid\Commands\MakeDataGridCommand;

class DataGridServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('datagrids')
            ->hasCommands([
                MakeDataGridCommand::class,
            ])
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        if (config('datagrids.route_registration.enabled')) {
            RegisterDataGridRoutesAction::make()->handle(
                config('datagrids.route_registration.discovery.paths'),
                ...config('datagrids.route_registration.discovery.conditions')
            );
        }
    }
}
