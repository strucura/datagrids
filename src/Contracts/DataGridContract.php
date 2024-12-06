<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Http\Requests\DataGridDataRequest;
use Strucura\DataGrid\Http\Requests\DataGridSchemaRequest;

interface DataGridContract
{
    public function getRoutePrefix(): string;

    public function getRoutePath(): string;

    public function getRouteName(): string;

    public function handleData(DataGridDataRequest $request): JsonResponse;

    public function handleSchema(DataGridSchemaRequest $request): JsonResponse;

    public function getColumns(): Collection;

    public function getQuery(): Builder;
}
