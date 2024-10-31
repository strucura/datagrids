<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Contracts\FilterContract;
use Strucura\Grids\Data\FilterData;

class NullFilter extends AbstractFilter implements FilterContract
{

    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $this->prepareFilterValueForDatabase($filterData->value) === null;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->value) {
            'equals' => $column->getSelectAs().' IS NULL',
            'notEquals' => $column->getSelectAs().' IS NOT NULL',
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
    }
}
