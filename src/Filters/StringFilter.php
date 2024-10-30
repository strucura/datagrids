<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Contracts\DataSourceContract;
use Strucura\Grids\Data\FilterData;

class StringFilter extends AbstractFilter
{
    /**
     * @throws \Exception
     */
    public function handle(Builder $query, DataSourceContract $dataSource, FilterData $filterData): Builder
    {
        $column = $this->matchFilterToColumn($dataSource, $filterData);

        $expression = match ($filterData->matchMode) {
            'startsWith' => $column->getSelectAs().' LIKE ?',
            'endsWith' => $column->getSelectAs().' LIKE ?',
            'contains' => $column->getSelectAs().' LIKE ?',
            'notContains' => $column->getSelectAs().' NOT LIKE ?',
            default => throw new \Exception('Invalid match mode for string filter'),
        };

        $value = match ($filterData->matchMode) {
            'startsWith' => $filterData->value.'%',
            'endsWith' => '%'.$filterData->value,
            'contains' => '%'.$filterData->value.'%',
            'notContains' => '%'.$filterData->value.'%',
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
