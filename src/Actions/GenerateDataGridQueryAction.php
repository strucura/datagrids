<?php

namespace Strucura\DataGrid\Actions;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Contracts\FilterContract;
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
     * @param  DataGridData  $gridData  The grid data containing the filters and sorts.
     * @return Builder The generated query builder instance.
     *
     * @throws Exception
     */
    public function handle(Builder $query, Collection $columns, DataGridData $gridData): Builder
    {
        $this->applyFilterSets($query, $columns, $gridData->filterSets);
        $this->applySorts($query, $gridData->sorts);

        foreach ($columns as $column) {
            $query->selectRaw("{$column->getSelectAs()} as `{$column->getColumnName()}`", $column->getBindings());
        }

        return $query;
    }

    /**
     * Apply filter sets to the query.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Collection<AbstractColumn>  $columns  The collection of columns.
     * @param  Collection<FilterSetData>  $filterSets  The collection of filters to apply.
     *
     * @throws Exception If a filter cannot be applied.
     */
    private function applyFilterSets(Builder $query, Collection $columns, Collection $filterSets): void
    {
        /** @var FilterSetData $filterSet */
        foreach ($filterSets as $filterSet) {
            $query->where(function (Builder $query) use ($columns, $filterSet) {
                $this->applyFilters($query, $columns, $filterSet->filters, $filterSet->filterOperator);
            });
        }
    }

    /**
     * Apply the filters in the filter set to the query
     *
     * @param Builder $query The query builder instance
     * @param Collection $columns The collection of columns
     * @param Collection $filters The collection of filters to apply in the set
     * @param FilterSetOperator $filterSetOperator The operator to use between filters
     *
     * @return void
     *
     * @throws Exception
     */
    private function applyFilters(Builder $query, Collection $columns, Collection $filters, FilterSetOperator $filterSetOperator): void
    {
        foreach ($filters as $filter) {
            /** @var AbstractColumn|null $column */
            $column = $columns->first(fn (AbstractColumn $col) => $col->getColumnName() === $filter->column);
            if (! $column) {
                continue;
            }

            $filterClass = $this->getMatchingFilterClass($column, $filter);
            if (! $filterClass) {
                throw new Exception("No filter found for column {$column->getColumnName()} with filter type {$filter->filterType->value}");
            }
            $filterClass->handle($query, $column, $filter, $filterSetOperator);
        }
    }

    /**
     * Find the filter class that can handle the given column and filter
     *
     * @param AbstractColumn $column The column to filter on
     * @param FilterData $filter The filter data
     *
     * @return FilterContract|null
     */
    private function getMatchingFilterClass(AbstractColumn $column, FilterData $filter): ?FilterContract
    {
        $availableFilters = config('datagrids.filters');

        foreach ($availableFilters as $filterClass) {
            /** @var FilterContract $filterInstance */
            $filterInstance = app($filterClass);
            if ($filterInstance->canHandle($column, $filter)) {
                return $filterInstance;
            }
        }

        return null;
    }

    /**
     * Apply sorts to the query.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Collection  $sorts  The collection of sorts to apply.
     *
     * @return void
     */
    private function applySorts(Builder $query, Collection $sorts): void
    {
        /** @var SortData[] $sorts */
        foreach ($sorts as $sort) {
            $query->orderBy($sort->column, $sort->sortType->value);
        }
    }
}
