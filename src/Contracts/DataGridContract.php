<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Http\Requests\DataGridDataRequest;
use Strucura\DataGrid\Http\Requests\DataGridSchemaRequest;

/**
 * The contract used for defining the data grid.
 */
interface DataGridContract
{
    /**
     * Used to get the route prefix for the data grid
     *
     * @return string
     */
    public function getRoutePrefix(): string;

    /**
     * Used to get the route path for the data grid
     *
     * @return string
     */
    public function getRoutePath(): string;

    /**
     * Used to make the route name for the data grid
     *
     * @return string
     */
    public function getRouteName(): string;

    /**
     * Used to get the row data for the data grid
     *
     * @param DataGridDataRequest $request
     * @return JsonResponse
     */
    public function handleData(DataGridDataRequest $request): JsonResponse;

    /**
     * Used to get the schema for the data grid.  This includes things like floating filters and columns.
     *
     * @param DataGridSchemaRequest $request
     * @return JsonResponse
     */
    public function handleSchema(DataGridSchemaRequest $request): JsonResponse;

    /**
     * Used to define the columns that will be available in the data grid
     *
     * @return Collection
     */
    public function getColumns(): Collection;

    /**
     * Used to define the floating filters that will be available in the data grid
     *
     * @return Collection
     */
    public function getFloatingFilters(): Collection;

    /**
     * The base query for the data grid.
     *
     * @return Builder
     */
    public function getQuery(): Builder;
}
