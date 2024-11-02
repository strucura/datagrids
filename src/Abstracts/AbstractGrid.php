<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Strucura\DataGrid\Actions\GenerateGridQueryAction;
use Strucura\DataGrid\Contracts\GridContract;
use Strucura\DataGrid\Data\GridData;
use Strucura\DataGrid\Requests\GridDataRequest;

abstract class AbstractGrid implements GridContract
{
    /**
     * Automatically generates the permission name based on the class name.
     *
     * @return string
     */
    public function getPermissionName(): string
    {
        return Str::of(static::class)->classBasename()->snake()->toString();
    }

    /**
     * Automatically generates the route name which will be used as Laravel's named route.
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return Str::of(static::class)->classBasename()->headline()->remove(' Grid')->toString();
    }

    /**
     * Automatically generates the route path which will be used as the URL path.
     *
     * @return string
     */
    public function getRoutePath(): string
    {
        return Str::of(static::class)->classBasename()->snake()->prepend('/')->append('grid')->toString();
    }

    /**
     * Handles the API request to get the data for the grid.
     *
     * @param GridDataRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function handleData(GridDataRequest $request): JsonResponse
    {
        $first = $request->input('first', 0);
        $last = $request->input('last', 100);

        $results = GenerateGridQueryAction::make()->handle(
            $this->getQuery(),
            $this->getColumns(),
            GridData::fromRequest($request)
        )
            ->take($last - $first)
            ->offset($first)
            ->get();

        return response()->json($results);
    }

    /**
     * Handles building the schema for consumption by the front-end.
     *
     * @return JsonResponse
     */
    public function handleSchema(): JsonResponse
    {
        $columns = $this->getColumns()->map(function(AbstractColumn $column) {
            return $column->toArray();
        });

        return response()->json($columns);
    }
}
