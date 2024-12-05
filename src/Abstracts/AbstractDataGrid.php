<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Strucura\DataGrid\Actions\GenerateDataGridQueryAction;
use Strucura\DataGrid\Contracts\DataGridContract;
use Strucura\DataGrid\Data\DataGridData;
use Strucura\DataGrid\Http\Requests\DataGridDataRequest;
use Strucura\DataGrid\Http\Requests\DataGridSchemaRequest;

abstract class AbstractDataGrid implements DataGridContract
{
    public function getRoutePrefix(): string
    {
        return 'grids';
    }

    /**
     * Automatically generates the route name which will be used as Laravel's named route.
     */
    public function getRouteName(): string
    {
        return Str::of(static::class)
            ->classBasename()
            ->before('DataGrid')
            ->snake('-')
            ->plural()
            ->prepend($this->getRoutePrefix().'.')
            ->toString();
    }

    /**
     * Automatically generates the route path which will be used as the URL path.
     */
    public function getRoutePath(): string
    {
        return Str::of(static::class)
            ->classBasename()
            ->before('DataGrid')
            ->plural()
            ->snake('-')
            ->prepend('/')
            ->prepend($this->getRoutePrefix())
            ->toString();
    }

    public function getDataGridKey(): string
    {
        return $this->getRouteName();
    }

    /**
     * Handles the API request to get the data for the grid.
     *
     * @throws \Exception
     */
    public function handleData(DataGridDataRequest $request): JsonResponse
    {
        if (method_exists($this, 'getPermissionName')) {
            Gate::authorize($this->getPermissionName());
        }

        $first = $request->input('first', 0);
        $last = $request->input('last', 100);

        $data = GenerateDataGridQueryAction::make()->handle(
            $this->getQuery(),
            $this->getColumns(),
            DataGridData::fromRequest($request)
        )
            ->take($last - $first)
            ->offset($first)
            ->get();

        $total = GenerateDataGridQueryAction::make()->handle(
            $this->getQuery(),
            $this->getColumns(),
            DataGridData::fromRequest($request)
        )->count();

        return response()->json([
            'rows' => $data,
            'row_count' => $total,
        ]);
    }

    /**
     * Handles building the schema for consumption by the front-end.
     */
    public function handleSchema(DataGridSchemaRequest $request): JsonResponse
    {
        if (method_exists($this, 'getPermissionName')) {
            Gate::authorize($this->getPermissionName());
        }

        $columns = $this->getColumns()->map(function (AbstractColumn $column) {
            return $column->toArray();
        });

        return response()->json([
            'columns' => $columns,
        ]);
    }
}
