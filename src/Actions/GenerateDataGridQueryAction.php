<?php

namespace Strucura\DataGrid\Actions;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilterInput;
use Strucura\DataGrid\Contracts\FilterOperationContract;
use Strucura\DataGrid\Contracts\QueryableContract;
use Strucura\DataGrid\Data\DataGridData;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Data\FilterSetData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\FilterSetOperator;

/**
 * Class GenerateDataGridQueryAction
 *
 * This class is responsible for generating a query for a grid based on the provided filters and sorts.
 */
class GenerateDataGridQueryAction
{
    public static function make(): self
    {
        return new self;
    }

    /**
     * Handle the generation of the grid query.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Collection<AbstractColumn>  $columns  The collection of columns to select.
     * @param  Collection<AbstractFilterInput>  $externalFilterInputs  The collection of eligible external filter inputs.
     * @param  DataGridData  $gridData  The grid data containing the filters and sorts.
     * @return Builder The generated query builder instance.
     *
     * @throws Exception
     */
    public function handle(Builder $query, Collection $columns, Collection $externalFilterInputs, DataGridData $gridData): Builder
    {
        /** @var Collection<QueryableContract> $queryableContracts */
        $queryableContracts = $columns->concat($externalFilterInputs->all());

        $this->applyFilterSets($query, $queryableContracts, $gridData->filterSets);
        $this->applySorts($query, $queryableContracts, $gridData->sorts);

        foreach ($columns as $column) {
            $query->selectRaw("{$column->getExpression()} as `{$column->getAlias()}`", $column->getBindings());
        }

        return $query;
    }

    private function getMatchingQueryableContract($key, Collection $queryableContracts): ?QueryableContract
    {
        return $queryableContracts->first(fn (QueryableContract $col) => $col->getAlias() === $key);
    }

    /**
     * Apply filter sets to the query.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Collection<QueryableContract>  $queryableContracts  A collection of columns and floating filters.
     * @param  Collection<FilterSetData>  $filterSets  The collection of filters to apply.
     *
     * @throws Exception If a filter cannot be applied.
     */
    private function applyFilterSets(Builder $query, Collection $queryableContracts, Collection $filterSets): void
    {
        /** @var FilterSetData $filterSet */
        foreach ($filterSets as $filterSet) {
            $query->where(function (Builder $query) use ($queryableContracts, $filterSet) {
                $this->applyFilters($query, $queryableContracts, $filterSet->filters, $filterSet->filterOperator);
            });
        }
    }

    /**
     * Apply the filters in the filter set to the query
     *
     * @param  Builder  $query  The query builder instance
     * @param  Collection<QueryableContract>  $queryableContracts  The collection of queryable contracts to apply filters to
     * @param  Collection<FilterData>  $filters  The collection of filters to apply in the set
     * @param  FilterSetOperator  $filterSetOperator  The operator to use between filters
     *
     * @throws Exception
     */
    private function applyFilters(Builder $query, Collection $queryableContracts, Collection $filters, FilterSetOperator $filterSetOperator): void
    {
        foreach ($filters as $filter) {
            /** @var QueryableContract|null $queryableContract */
            $queryableContract = $this->getMatchingQueryableContract($filter->alias, $queryableContracts);
            if (empty($queryableContract)) {
                continue;
            }

            $filterClass = $this->getMatchingFilterClass($queryableContract, $filter);
            if (! $filterClass) {
                throw new Exception("No filter operation found for {$queryableContract->getAlias()} with filter operator {$filter->filterOperator->value}");
            }
            $filterClass->handle($query, $queryableContract, $filter, $filterSetOperator);
        }
    }

    /**
     * Find the filter class that can handle the given column and filter
     *
     * @param  QueryableContract  $queryableContract  The queryable contract to filter on
     * @param  FilterData  $filter  The filter data
     */
    private function getMatchingFilterClass(QueryableContract $queryableContract, FilterData $filter): ?FilterOperationContract
    {
        $availableFilters = config('datagrids.filter_operations');

        foreach ($availableFilters as $filterClass) {
            /** @var FilterOperationContract $filterInstance */
            $filterInstance = app($filterClass);
            if ($filterInstance->canHandle($queryableContract, $filter)) {
                return $filterInstance;
            }
        }

        return null;
    }

    /**
     * Apply sorts to the query.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Collection<QueryableContract>  $queryableContracts  A collection of columns and floating filters.
     * @param  Collection<SortData>  $sorts  The collection of sorts to apply.
     */
    private function applySorts(Builder $query, Collection $queryableContracts, Collection $sorts): void
    {
        /** @var Collection<SortData> $sorts */
        foreach ($sorts as $sort) {
            $queryableContract = $this->getMatchingQueryableContract($sort->alias, $queryableContracts);

            /**
             * If the queryable contract is not found, then we can't sort by it.
             */
            if (empty($queryableContract)) {
                continue;
            }

            $query->orderBy($queryableContract->getAlias(), $sort->sortOperator->value);
        }
    }
}
