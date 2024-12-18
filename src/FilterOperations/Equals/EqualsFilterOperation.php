<?php

namespace Strucura\DataGrid\FilterOperations\Equals;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractFilterOperation;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class EqualsFilterOperation extends AbstractFilterOperation
{
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::EQUALS && $this->getNormalizedValue($filterData->value) !== null;
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
            return $queryableContract->getExpression().' IS NULL';
        }

        return $queryableContract->getExpression().' = ?';
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
