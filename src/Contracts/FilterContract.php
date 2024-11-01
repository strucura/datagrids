<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;

interface FilterContract
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool;

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder;
}
