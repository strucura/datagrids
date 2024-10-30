<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Contracts\DataSourceContract;
use Strucura\Grids\Data\FilterData;

class EqualityFilter extends AbstractFilter
{
    /**
     * @throws \Exception
     */
    public function handle(Builder $query, DataSourceContract $dataSource, FilterData $filterData): Builder
    {
        $column = $this->matchFilterToColumn($dataSource, $filterData);

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
