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
     */
    public function getRoutePrefix(): string;

    /**
     * Used to get the route path for the data grid
     */
    public function getRoutePath(): string;

    /**
     * Used to make the route name for the data grid
     */
    public function getRouteName(): string;

    /**
     * Used to get the row data for the data grid
     */
    public function handleData(DataGridDataRequest $request): JsonResponse;

    /**
     * Used to get the schema for the data grid.  This includes things like floating filters and columns.
     */
    public function handleSchema(DataGridSchemaRequest $request): JsonResponse;

    /**
     * Used to define the columns that will be available in the data grid
     */
    public function getColumns(): Collection;

    /**
     * Used to define the filter inputs that will be available to be applied to the data grid, but will live outside
     * the data grid.
     */
    public function getExternalFilterInputs(): Collection;

    /**
     * The base query for the data grid.
     */
    public function getQuery(): Builder;
}
