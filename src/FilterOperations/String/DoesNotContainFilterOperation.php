<?php

namespace Strucura\DataGrid\FilterOperations\String;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractFilterOperation;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class DoesNotContainFilterOperation extends AbstractFilterOperation
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool
    {
        return $filterData->filterOperator === FilterOperator::STRING_DOES_NOT_CONTAIN;
    }

    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = $queryableContract->getExpression().' NOT LIKE ? OR '.$queryableContract->getExpression().' IS NULL';
        $value = '%'.$filterData->value.'%';
        $bindings = [...$queryableContract->getBindings(), $value];

        $method = $this->getQueryMethod($queryableContract, $filterOperator);
        $query->$method($expression, $bindings);

        return $query;
    }
}
