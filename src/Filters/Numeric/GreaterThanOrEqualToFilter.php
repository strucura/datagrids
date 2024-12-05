<?php

namespace Strucura\DataGrid\Filters\Numeric;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class GreaterThanOrEqualToFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::GREATER_THAN_OR_EQUAL_TO;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = $column->getSelectAs().' >= ?';
        $bindings = [...$column->getBindings(), $filterData->value];

        $method = $this->getQueryMethod($column, $filterOperator);
        $query->$method($expression, $bindings);

        return $query;
    }
}
