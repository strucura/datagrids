<?php

namespace Strucura\Grids\Contracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

interface GridContract
{
    public function getColumns(): Collection;

    public function getQuery(): Builder;
}
