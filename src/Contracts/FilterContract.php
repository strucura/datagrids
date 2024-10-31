<?php

namespace Strucura\Grids\Contracts;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Data\FilterData;

interface FilterContract
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool;

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder;
}
