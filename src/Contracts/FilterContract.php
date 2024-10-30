<?php

namespace Strucura\Grids\Contracts;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Data\FilterData;

interface FilterContract
{
    public function handle(Builder $query, DataSourceContract $dataSource, FilterData $filterData): Builder;

    public function matchFilterToColumn(DataSourceContract $dataSource, FilterData $filterData): AbstractColumn;
}
