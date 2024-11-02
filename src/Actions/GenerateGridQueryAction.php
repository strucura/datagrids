<?php

namespace Strucura\DataGrid\Actions;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Contracts\FilterContract;
use Strucura\DataGrid\Contracts\GridContract;
use Strucura\DataGrid\Data\GridData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\SortTypeEnum;

/**
 * Class GenerateGridQueryAction
 *
 * This class is responsible for generating a query for a grid based on the provided filters and sorts.
 */
class GenerateGridQueryAction
{
    public static function make(): self
    {
        return new self();
    }
    /**
     * Handle the generation of the grid query.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Collection  $columns  The collection of columns to select.
     * @param  GridData  $gridData  The grid data containing the filters and sorts.
     * @return Builder The generated query builder instance.
     *
     * @throws \Exception
     */
    public function handle(Builder $query, Collection $columns, GridData $gridData): Builder
    {
        $this->applyFilters($query, $columns, $gridData->filters);
        $this->applySorts($query, $gridData->sorts);

        foreach ($columns as $column) {
            $query->selectRaw("{$column->getSelectAs()} as `{$column->getAlias()}`", $column->getBindings());
        }

        return $query;
    }

    /**
     * Apply filters to the query.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Collection  $columns  The collection of columns.
     * @param  Collection  $filters  The collection of filters to apply.
     *
     * @throws \Exception If a filter cannot be applied.
     */
    private function applyFilters(Builder $query, Collection $columns, Collection $filters): void
    {
        $availableFilters = config('datagrids.filters');

        foreach ($filters as $filter) {
            $column = $columns->first(fn (AbstractColumn $col) => $col->getAlias() === $filter->column);
            if (! $column) {
                continue;
            }

            foreach ($availableFilters as $filterClass) {
                /** @var FilterContract $filterInstance */
                $filterInstance = app($filterClass);
                if ($filterInstance->canHandle($column, $filter)) {
                    $filterInstance->handle($query, $column, $filter);
                }
            }
        }
    }

    /**
     * Apply sorts to the query.
     *
     * @param  Builder  $query  The query builder instance.
     * @param  Collection  $sorts  The collection of sorts to apply.
     */
    private function applySorts(Builder $query, Collection $sorts): void
    {
        /** @var SortData[] $sorts */
        foreach ($sorts as $sort) {
            $query->orderBy($sort->column, $sort->sortType->value);
        }
    }
}
