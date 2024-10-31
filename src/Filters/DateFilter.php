<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterTypeEnum;

class DateFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::DATE_IS,
            FilterTypeEnum::DATE_IS_NOT,
            FilterTypeEnum::BEFORE,
            FilterTypeEnum::DATE_BEFORE,
            FilterTypeEnum::AFTER,
            FilterTypeEnum::DATE_AFTER,
            FilterTypeEnum::DOESNT_HAVE,
        ]);
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->filterType) {
            FilterTypeEnum::DATE_IS => $column->getSelectAs()." = DATE_FORMAT(?, '%Y-%m-%d %T')",
            FilterTypeEnum::AFTER, FilterTypeEnum::DATE_AFTER => $column->getSelectAs()." > DATE_FORMAT(?, '%Y-%m-%d %T')",
            FilterTypeEnum::BEFORE, FilterTypeEnum::DATE_BEFORE => $column->getSelectAs()." < DATE_FORMAT(?, '%Y-%m-%d %T')",
            FilterTypeEnum::DATE_IS_NOT => $column->getSelectAs()." != DATE_FORMAT(?, '%Y-%m-%d %T')",
            default => throw new \Exception('Invalid match mode for date filter'),
        };

        if ($column->isHavingRequired()) {
            $query->havingRaw($expression.' = ?', [
                ...$column->getBindings(),
                $filterData->value,
            ]);
        } else {
            $query->whereRaw($expression.' = ?', [
                ...$column->getBindings(),
                $filterData->value,
            ]);
        }

        return $query;
    }
}
