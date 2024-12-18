<?php

namespace Strucura\DataGrid\FilterOperations\String;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractFilterOperation;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class EndsWithFilterOperation extends AbstractFilterOperation
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool
    {
        return $filterData->filterOperator === FilterOperator::STRING_ENDS_WITH;
    }

    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = $queryableContract->getExpression().' LIKE ?';
        $value = '%'.$filterData->value;

        $bindings = [...$queryableContract->getBindings(), $value];

        $method = $this->getQueryMethod($queryableContract, $filterOperator);
        $query->$method($expression, $bindings);

        return $query;
    }
}
