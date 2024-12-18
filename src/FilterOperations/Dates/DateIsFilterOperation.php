<?php

namespace Strucura\DataGrid\FilterOperations\Dates;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractFilterOperation;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class DateIsFilterOperation extends AbstractFilterOperation
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool
    {
        return $filterData->filterOperator === FilterOperator::DATE_IS;
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = "{$queryableContract->getExpression()} = DATE_FORMAT(?, '%Y-%m-%d')";

        $method = $this->getQueryMethod($queryableContract, $filterOperator);
        $query->$method($expression, [...$queryableContract->getBindings(), $filterData->value]);

        return $query;
    }
}
