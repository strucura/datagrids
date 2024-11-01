<?php

namespace Strucura\DataGrid\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;

class EqualityFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::EQUALS,
            FilterTypeEnum::NOT_EQUALS,
        ]) && $this->getNormalizedValue($filterData->value) !== null;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = $this->buildExpression($column, $filterData);
        $bindings = $this->buildBindings($column, $filterData);

        if ($column->isHavingRequired()) {
            $query->havingRaw($expression, $bindings);
        } else {
            $query->whereRaw($expression, $bindings);
        }

        return $query;
    }

    private function buildExpression(AbstractColumn $column, FilterData $filterData): string
    {
        if ($filterData->value === null) {
            return $filterData->filterType === FilterTypeEnum::EQUALS
                ? $column->getSelectAs().' IS NULL'
                : $column->getSelectAs().' IS NOT NULL';
        }

        return $filterData->filterType === FilterTypeEnum::EQUALS
            ? $column->getSelectAs().' = ?'
            : $column->getSelectAs().' != ?';
    }

    private function buildBindings(AbstractColumn $column, FilterData $filterData): array
    {
        if ($filterData->value === null) {
            return $column->getBindings();
        }

        return [
            ...$column->getBindings(),
            $filterData->value,
        ];
    }
}
