<?php

namespace Strucura\DataGrid\Filters\In;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class InFilter extends AbstractFilter
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::IN;
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        // Normalize the values
        $values = collect($filterData->value)->map(function ($value) {
            return $this->getNormalizedValue($value);
        })->toArray();

        // You MUST have one parameter per item in the array
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $bindings = array_merge($queryableContract->getBindings(), $values);

        // Build the expression
        $expression = $queryableContract->getSelectAs()." IN ($placeholders)";

        $method = $this->getQueryMethod($queryableContract, $filterOperator);
        $query->$method($expression, $bindings);

        // If one of the values is null, we need to add a whereNull clause
        if (in_array(null, $values)) {
            $query->orWhereNull($queryableContract->getSelectAs());
        }

        return $query;
    }
}
