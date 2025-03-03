<?php

namespace Strucura\DataGrid\FilterOperations\Equality;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractFilterOperation;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class LessThanFilterOperation extends AbstractFilterOperation
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool
    {
        return in_array($filterData->filterOperator, [FilterOperator::LESS_THAN, FilterOperator::DATE_BEFORE]);
    }

    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = $queryableContract->getExpression().' < ?';
        $bindings = [...$queryableContract->getBindings(), $filterData->value];

        $method = $this->getQueryMethod($queryableContract, $filterOperator);
        $query->$method($expression, $bindings);

        return $query;
    }
}
