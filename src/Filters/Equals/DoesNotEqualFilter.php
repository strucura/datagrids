<?php

namespace Strucura\DataGrid\Filters\Equals;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class DoesNotEqualFilter extends AbstractFilter
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::NOT_EQUALS && $this->getNormalizedValue($filterData->value) !== null;
    }

    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        $expression = $this->buildExpression($queryableContract, $filterData);
        $bindings = $this->buildBindings($queryableContract, $filterData);

        $method = $this->getQueryMethod($queryableContract, $filterOperator);
        $query->$method($expression, $bindings);

        return $query;
    }

    private function buildExpression(QueryableContract $queryableContract, FilterData $filterData): string
    {
        if ($filterData->value === null) {
            return $queryableContract->getSelectAs().' IS NOT NULL';
        }

        return $queryableContract->getSelectAs().' != ?';
    }

    private function buildBindings(QueryableContract $queryableContract, FilterData $filterData): array
    {
        if ($filterData->value === null) {
            return $queryableContract->getBindings();
        }

        return [
            ...$queryableContract->getBindings(),
            $filterData->value,
        ];
    }
}
