<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterTypeEnum;

class StringFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::STARTS_WITH,
            FilterTypeEnum::ENDS_WITH,
            FilterTypeEnum::CONTAINS,
            FilterTypeEnum::NOT_CONTAINS,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->filterType) {
            FilterTypeEnum::STARTS_WITH,
            FilterTypeEnum::ENDS_WITH,
            FilterTypeEnum::CONTAINS => $column->getSelectAs().' LIKE ?',
            FilterTypeEnum::NOT_CONTAINS => $column->getSelectAs().' NOT LIKE ?',
            default => throw new \Exception('Invalid match mode for string filter'),
        };

        $value = match ($filterData->filterType) {
            FilterTypeEnum::STARTS_WITH => $filterData->value.'%',
            FilterTypeEnum::ENDS_WITH => '%'.$filterData->value,
            FilterTypeEnum::CONTAINS, FilterTypeEnum::NOT_CONTAINS => '%'.$filterData->value.'%',
            default => throw new \Exception('Invalid match mode for string filter'),
        };

        if ($column->isHavingRequired()) {
            $query->havingRaw($expression, [...$column->getBindings(), $value]);
        } else {
            $query->whereRaw($expression, [...$column->getBindings(), $value]);
        }

        return $query;
    }
}
