<?php

namespace Strucura\DataGrid\Filters\Dates;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class DateBeforeFilter extends AbstractFilter
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::DATE_BEFORE;
    }

    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = "{$queryableContract->getExpression()} < DATE_FORMAT(?, '%Y-%m-%d')";

        $method = $this->getQueryMethod($queryableContract, $filterOperator);
        $query->$method($expression, [...$queryableContract->getBindings(), $filterData->value]);

        return $query;
    }
}
