<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterMatchModeEnum;

class NumericFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->matchMode, [
            FilterMatchModeEnum::LESS_THAN,
            FilterMatchModeEnum::LESS_THAN_OR_EQUAL_TO,
            FilterMatchModeEnum::GREATER_THAN,
            FilterMatchModeEnum::GREATER_THAN_OR_EQUAL_TO,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->matchMode) {
            'lt' => $column->getSelectAs().' < ?',
            'lte' => $column->getSelectAs().' <= ?',
            'gt' => $column->getSelectAs().' > ?',
            'gte' => $column->getSelectAs().' >= ?',
            default => throw new \Exception('Invalid match mode for numeric filter'),
        };

        if ($column->isHavingRequired()) {
            $query->havingRaw($expression, [
                ...$column->getBindings(),
                $filterData->value,
            ]);
        } else {
            $query->whereRaw($expression, [
                ...$column->getBindings(),
                $filterData->value,
            ]);
        }

        return $query;
    }
}
