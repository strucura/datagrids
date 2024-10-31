<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Contracts\DataSourceContract;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterMatchModeEnum;

class StringFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->matchMode, [
            FilterMatchModeEnum::STARTS_WITH,
            FilterMatchModeEnum::ENDS_WITH,
            FilterMatchModeEnum::CONTAINS,
            FilterMatchModeEnum::NOT_CONTAINS,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->matchMode) {
            'startsWith', 'contains', 'endsWith' => $column->getSelectAs().' LIKE ?',
            'notContains' => $column->getSelectAs().' NOT LIKE ?',
            default => throw new \Exception('Invalid match mode for string filter'),
        };

        $value = match ($filterData->matchMode) {
            'startsWith' => $filterData->value.'%',
            'endsWith' => '%'.$filterData->value,
            'contains', 'notContains' => '%'.$filterData->value.'%',
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
