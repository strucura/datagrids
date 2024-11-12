<?php

namespace Strucura\DataGrid\Filters\In;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;

class NotInFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterTypeEnum::NOT_IN;
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
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

        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method($expression, $bindings);

        return $query;
    }
}
