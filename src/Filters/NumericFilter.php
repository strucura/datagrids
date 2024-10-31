<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterTypeEnum;

class NumericFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::LESS_THAN,
            FilterTypeEnum::LESS_THAN_OR_EQUAL_TO,
            FilterTypeEnum::GREATER_THAN,
            FilterTypeEnum::GREATER_THAN_OR_EQUAL_TO,
        ]);
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->filterType) {
            FilterTypeEnum::LESS_THAN => $column->getSelectAs().' < ?',
            FilterTypeEnum::LESS_THAN_OR_EQUAL_TO => $column->getSelectAs().' <= ?',
            FilterTypeEnum::GREATER_THAN => $column->getSelectAs().' > ?',
            FilterTypeEnum::GREATER_THAN_OR_EQUAL_TO => $column->getSelectAs().' >= ?',
            default => throw new \Exception('Invalid match mode for numeric filter'),
        };

        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method($expression, [...$column->getBindings(), $filterData->value]);

        return $query;
    }
}
