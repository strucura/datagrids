<?php

namespace Strucura\DataGrid\Actions;

use Illuminate\Support\Facades\Route;
use Spatie\StructureDiscoverer\Discover;
use Spatie\StructureDiscoverer\DiscoverConditions\DiscoverCondition;
use Spatie\StructureDiscoverer\Support\Conditions\HasConditions;
use Strucura\DataGrid\Contracts\DataGridContract;

class RegisterDataGridRoutesAction
{
    public static function make(): self
    {
        return new self;
    }

    public function handle(array $paths = [], DiscoverCondition|HasConditions ...$conditions): void
    {
        $discoveredGridFQCNs = Discover::in(...$paths)
            ->any(...$conditions)
            ->get();

        foreach ($discoveredGridFQCNs as $gridFQCN) {
            /** @var DataGridContract $grid */
            $grid = new $gridFQCN;
            Route::post($grid->getRoutePath().'/data', [$gridFQCN, 'handleData'])->name($grid->getRouteName().'.data');
            Route::post($grid->getRoutePath().'/schema', [$gridFQCN, 'handleSchema'])->name($grid->getRouteName().'.schema');
        }
    }
}
