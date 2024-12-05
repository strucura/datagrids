<?php

namespace Strucura\DataGrid\Filters\In;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class NotInFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::NOT_IN;
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        // Normalize the values
        $values = collect($filterData->value)->map(function ($value) {
            return $this->getNormalizedValue($value);
        })->toArray();

        // You MUST have one parameter per item in the array
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $bindings = array_merge($column->getBindings(), $values);

        // Build the expression
        $expression = $column->getSelectAs()." NOT IN ($placeholders)";

        $method = $this->getQueryMethod($column, $filterOperator);
        $query->$method($expression, $bindings);

        // If one of the values is null, we need to add a whereNotNull clause
        if (in_array(null, $values)) {
            $query->orWhereNotNull($column->getSelectAs());
        }

        return $query;
    }
}
