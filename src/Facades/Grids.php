<?php

namespace Strucura\Grids\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Strucura\Grids\Grids
 */
class Grids extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Strucura\Grids\Grids::class;
    }
}
