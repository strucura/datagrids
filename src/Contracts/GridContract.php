<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Requests\GridDataRequest;

interface GridContract
{
    public function getRoutePrefix(): string;

    public function getRoutePath(): string;

    public function getRouteName(): string;

    public function handleData(GridDataRequest $request): JsonResponse;

    public function handleSchema(): JsonResponse;

    public function getColumns(): Collection;

    public function getQuery(): Builder;
}
