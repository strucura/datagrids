<?php

namespace Strucura\DataGrid;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\StructureDiscoverer\Discover;
use Strucura\DataGrid\Contracts\GridContract;

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
            ->hasConfigFile();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function packageRegistered(): void
    {
        $paths = config('datagrids.discovery.paths');
        $conditions = config('datagrids.discovery.conditions');

        $discoveredGridFQCNs = Discover::in(...$paths)
            ->any(...$conditions)
            ->get();

        foreach ($discoveredGridFQCNs as $gridFQCN) {
            /** @var GridContract $grid */
            $grid = new $gridFQCN;
            Route::post($grid->getRoutePath().'/data', [$gridFQCN, 'handleData'])->name($grid->getRouteName().'.data');
            Route::post($grid->getRoutePath().'/schema', [$gridFQCN, 'handleSchema'])->name($grid->getRouteName().'.schema');
            Route::get($grid->getRoutePath().'/settings', [$gridFQCN, 'handleRetrievingSettings'])->name($grid->getRouteName().'.settings.index');
            Route::post($grid->getRoutePath().'/settings', [$gridFQCN, 'handlePersistingSetting'])->name($grid->getRouteName().'.settings.store');
        }
    }
}
