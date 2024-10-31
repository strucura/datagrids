<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterMatchModeEnum;

class DateFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->matchMode, [
            FilterMatchModeEnum::DATE_IS,
            FilterMatchModeEnum::DATE_IS_NOT,
            FilterMatchModeEnum::DATE_BEFORE,
            FilterMatchModeEnum::DATE_AFTER,
            FilterMatchModeEnum::DOESNT_HAVE,
        ]);
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->matchMode) {
            'dateIs' => $column->getSelectAs()." = DATE_FORMAT(?, '%Y-%m-%d %T')",
            'dateAfter' => $column->getSelectAs()." > DATE_FORMAT(?, '%Y-%m-%d %T')",
            'dateBefore' => $column->getSelectAs()." < DATE_FORMAT(?, '%Y-%m-%d %T')",
            'dateIsNot' => $column->getSelectAs()." != DATE_FORMAT(?, '%Y-%m-%d %T')",
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
