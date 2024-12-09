<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterSetOperator;

interface FilterContract
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool;

    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder;
}
