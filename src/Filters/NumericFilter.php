<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Contracts\DataSourceContract;
use Strucura\Grids\Data\FilterData;

class NumericFilter extends AbstractFilter
{
    /**
     * @throws \Exception
     */
    public function handle(Builder $query, DataSourceContract $dataSource, FilterData $filterData): Builder
    {
        $column = $this->matchFilterToColumn($dataSource, $filterData);

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
