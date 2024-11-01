<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterTypeEnum;

class InFilter extends AbstractFilter
{

    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::IN,
            FilterTypeEnum::NOT_IN,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        // You MUST have one parameter per item in the array
        $placeholders = implode(',', array_fill(0, count($filterData->value), '?'));
        $bindings     = array_merge($column->getBindings(), $filterData->value);

        $expression = match ($filterData->filterType) {
            FilterTypeEnum::IN => $column->getSelectAs() . " IN ($placeholders)",
            FilterTypeEnum::NOT_IN => $column->getSelectAs() . " NOT IN ($placeholders)",
            default => throw new \Exception('Invalid match mode for IN filter'),
        };

        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method($expression, $bindings);

        return $query;
    }
}
