<?php

namespace Strucura\DataGrid\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Strucura\DataGrid\DataGrid
 */
class DataGrid extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Strucura\DataGrid\DataGrid::class;
    }
}
