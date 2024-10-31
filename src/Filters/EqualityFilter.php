<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterTypeEnum;

class EqualityFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::EQUALS,
            FilterTypeEnum::IS,
            FilterTypeEnum::NOT_EQUALS,
            FilterTypeEnum::IS_NOT,
        ]) && $this->getTransformedFilterValue($filterData->value) !== null;
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->filterType) {
            FilterTypeEnum::EQUALS => $column->getSelectAs().' = ?',
            FilterTypeEnum::NOT_EQUALS => $column->getSelectAs().' != ?',
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
