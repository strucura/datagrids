<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterMatchModeEnum;

class EqualityFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->matchMode, [
            FilterMatchModeEnum::EQUALS,
            FilterMatchModeEnum::IS,
            FilterMatchModeEnum::NOT_EQUALS,
            FilterMatchModeEnum::IS_NOT,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->matchMode) {
            'equals' => $column->getSelectAs().' = ?',
            'notEquals' => $column->getSelectAs().' != ?',
            default => throw new \Exception('Invalid match mode for equality filter'),
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
