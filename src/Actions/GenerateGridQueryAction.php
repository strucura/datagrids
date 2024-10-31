<?php

namespace Strucura\Grids\Actions;

use Illuminate\Database\Query\Builder;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Contracts\GridContract;
use Strucura\Grids\Contracts\ValueTransformerContract;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Data\SortData;

class GenerateGridQueryAction
{
    public function handle(GridContract $gridContract, Collection $filters, Collection $sorts): Builder
    {
        $filteredQuery = $gridContract->getQuery();

        $this->applyFilters(
            $filteredQuery,
            $dataSource,
            $this->transformFilterValues($filters)
        );

        $this->applySorts($filteredQuery, $sorts);

        /** @var AbstractColumn $column */
        foreach ($gridContract->getColumns() as $column) {
            $filteredQuery->selectRaw(
                $column->getSelectAs().' as `'.$column->getAlias().'`',
                $column->getBindings()
            );
        }

        return $filteredQuery;
    }

    /**
     * @param  Collection<FilterData>  $filters
     */
    public function transformFilterValues(Collection $filters): Collection
    {
        /** @var array<ValueTransformerContract> $transformers */
        $transformers = config('data-visualizations.value_transformers');

        foreach ($filters as $filter) {
            /** @var Pipeline $pipeline */
            $pipeline = app(Pipeline::class);
            $filter->value = $pipeline->send($filter->value)
                ->through($transformers)
                ->thenReturn();
        }

        return $filters;
    }

    public function applyFilters(Builder $query, DataSourceContract $dataSource, Collection $filters): Builder
    {
        /** @var array<FilterData> $filters */
        foreach ($filters as $filter) {
            $availableFilters = config('grids.filters');

            if (! isset($availableFilters[$filter->matchMode])) {
                continue;
            }

            /** @var AbstractFilter $filterDefinitionInstance */
            $filterDefinitionInstance = app($availableFilters[$filter->matchMode]);

            $filterDefinitionInstance->handle($query, $dataSource, $filter);
        }

        return $query;
    }

    public function applySorts(Builder $query, Collection $sorts): Builder
    {
        $sorts->each(function (SortData $sort) use ($query) {
            $sortDirection = match ($sort->order) {
                1 => 'asc',
                -1 => 'desc',
                default => null,
            };

            if ($sortDirection === null) {
                return;
            }

            $query->orderBy($sort->column, $sortDirection);
        });

        return $query;
    }
}
