<?php

namespace Strucura\Grids\Actions;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Contracts\FilterContract;
use Strucura\Grids\Contracts\GridContract;
use Strucura\Grids\Contracts\SortOrderEnum;

/**
 * Class GenerateGridQueryAction
 *
 * This class is responsible for generating a query for a grid based on the provided filters and sorts.
 */
class GenerateGridQueryAction
{
    /**
     * Handle the generation of the grid query.
     *
     * @param GridContract $gridContract The grid contract instance.
     * @param Collection $filters The collection of filters to apply.
     * @param Collection $sorts The collection of sorts to apply.
     * @return Builder The generated query builder instance.
     * @throws \Exception
     */
    public function handle(GridContract $gridContract, Collection $filters, Collection $sorts): Builder
    {
        $query = $gridContract->getQuery();

        $this->applyFilters($query, $gridContract->getColumns(), $filters);
        $this->applySorts($query, $sorts);

        foreach ($gridContract->getColumns() as $column) {
            $query->selectRaw("{$column->getSelectAs()} as `{$column->getAlias()}`", $column->getBindings());
        }

        return $query;
    }

    /**
     * Apply filters to the query.
     *
     * @param Builder $query The query builder instance.
     * @param Collection $columns The collection of columns.
     * @param Collection $filters The collection of filters to apply.
     * @throws \Exception If a filter cannot be applied.
     */
    private function applyFilters(Builder $query, Collection $columns, Collection $filters): void
    {
        $availableFilters = config('grids.filters');

        foreach ($filters as $filter) {
            $column = $columns->first(fn(AbstractColumn $col) => $col->getAlias() === $filter->column);
            if (!$column) continue;

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
     * @param Builder $query The query builder instance.
     * @param Collection $sorts The collection of sorts to apply.
     */
    private function applySorts(Builder $query, Collection $sorts): void
    {
        foreach ($sorts as $sort) {
            $direction = $sort->order === SortOrderEnum::ASC ? 'asc' : 'desc';
            $query->orderBy($sort->column, $direction);
        }
    }
}
