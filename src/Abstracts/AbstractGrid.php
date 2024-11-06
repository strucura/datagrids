<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Strucura\DataGrid\Actions\GenerateGridQueryAction;
use Strucura\DataGrid\Actions\ResolveUserDataGridSettingsAction;
use Strucura\DataGrid\Actions\SaveDataGridSettingAction;
use Strucura\DataGrid\Contracts\GridContract;
use Strucura\DataGrid\Data\DataGridSettingData;
use Strucura\DataGrid\Data\GridData;
use Strucura\DataGrid\Http\Requests\DataGridSettingsRequest;
use Strucura\DataGrid\Http\Requests\GridDataRequest;
use Strucura\DataGrid\Http\Requests\GridSchemaRequest;
use Strucura\DataGrid\Http\Requests\PersistDataGridSettingRequest;
use Strucura\DataGrid\Http\Resources\PersistDataGridSettingResource;

abstract class AbstractGrid implements GridContract
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
            ->before('Grid')
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
            ->before('Grid')
            ->plural()
            ->snake('-')
            ->prepend('/')
            ->prepend($this->getRoutePrefix())
            ->toString();
    }

    /**
     * Handles the API request to get the data for the grid.
     *
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
     */
    public function handleSchema(GridSchemaRequest $request): JsonResponse
    {
        $columns = $this->getColumns()->map(function (AbstractColumn $column) {
            return $column->toArray();
        });

        return response()->json($columns);
    }

    public function handleSettings(DataGridSettingsRequest $request): AnonymousResourceCollection
    {
        $action = new ResolveUserDataGridSettingsAction;

        $dataGridSettings = $action->handle(auth()->user(), $request->get('grid_key'));

        return PersistDataGridSettingResource::collection($dataGridSettings);
    }

    public function handlePersistingSetting(PersistDataGridSettingRequest $request): PersistDataGridSettingResource
    {
        $settings = DataGridSettingData::fromRequest($request);

        $dataGridSetting = SaveDataGridSettingAction::make()->handle($settings);

        return PersistDataGridSettingResource::make($dataGridSetting);
    }
}
