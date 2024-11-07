<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Http\Requests\GridDataRequest;
use Strucura\DataGrid\Http\Requests\GridSchemaRequest;
use Strucura\DataGrid\Http\Requests\PersistDataGridSettingRequest;
use Strucura\DataGrid\Http\Requests\RetrieveDataGridSettingsRequest;
use Strucura\DataGrid\Http\Resources\DataGridSettingResource;

interface GridContract
{
    public function getRoutePrefix(): string;

    public function getRoutePath(): string;

    public function getRouteName(): string;

    public function handleData(GridDataRequest $request): JsonResponse;

    public function handleSchema(GridSchemaRequest $request): JsonResponse;

    public function handleRetrievingSettings(RetrieveDataGridSettingsRequest $request): AnonymousResourceCollection;

    public function handlePersistingSetting(PersistDataGridSettingRequest $request): DataGridSettingResource;

    public function getColumns(): Collection;

    public function getQuery(): Builder;
}
