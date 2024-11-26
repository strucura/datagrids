<?php

namespace Strucura\DataGrid\Filters\Equals;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterSetOperator;
use Strucura\DataGrid\Enums\FilterOperator;

class DoesNotEqualFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::NOT_EQUALS && $this->getNormalizedValue($filterData->value) !== null;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = $this->buildExpression($column, $filterData);
        $bindings = $this->buildBindings($column, $filterData);

        $method = $this->getQueryMethod($column, $filterOperator);
        $query->$method($expression, $bindings);

        return $query;
    }

    private function buildExpression(AbstractColumn $column, FilterData $filterData): string
    {
        if ($filterData->value === null) {
            return $column->getSelectAs().' IS NOT NULL';
        }

        return $column->getSelectAs().' != ?';
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
