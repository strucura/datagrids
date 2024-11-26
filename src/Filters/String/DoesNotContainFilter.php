<?php

namespace Strucura\DataGrid\Filters\String;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class DoesNotContainFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::STRING_DOES_NOT_CONTAIN;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = $column->getSelectAs().' NOT LIKE ?';
        $value = '%'.$filterData->value.'%';
        $bindings = [...$column->getBindings(), $value];

        $method = $this->getQueryMethod($column, $filterOperator);
        $query->$method($expression, $bindings);

        return $query;
    }
}
