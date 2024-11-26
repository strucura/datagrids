<?php

namespace Strucura\DataGrid\Filters\Dates;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterSetOperator;
use Strucura\DataGrid\Enums\FilterOperator;

class DateIsFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::DATE_IS;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = "{$column->getSelectAs()} = DATE_FORMAT(?, '%Y-%m-%d %T')";
        $method = $this->getQueryMethod($column, $filterOperator);
        $query->$method($expression, [...$column->getBindings(), $filterData->value]);

        return $query;
    }
}
