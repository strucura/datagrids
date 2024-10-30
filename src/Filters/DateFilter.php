<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Contracts\DataSourceContract;
use Strucura\Grids\Data\FilterData;

class DateFilter extends AbstractFilter
{
    public function handle(Builder $query, DataSourceContract $dataSource, FilterData $filterData): Builder
    {
        $column = $this->matchFilterToColumn($dataSource, $filterData);

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
