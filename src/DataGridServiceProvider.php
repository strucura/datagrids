<?php

namespace Strucura\DataGrid;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\StructureDiscoverer\Discover;
use Strucura\DataGrid\Actions\RegisterDataGridRoutesAction;
use Strucura\DataGrid\Commands\MakeDataGridCommand;
use Strucura\DataGrid\Contracts\DataGridContract;

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

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function packageRegistered(): void
    {
        if (config('datagrids.route_registration.enabled')) {
            RegisterDataGridRoutesAction::make()->handle(
                config('datagrids.route_registration.paths'),
                config('datagrids.route_registration.conditions')
            );
        }
    }
}
