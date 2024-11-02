<?php

namespace Strucura\DataGrid\Contracts;

interface ColumnContract
{
    public function __construct(string $queryColumn, string $alias);

    public function getSelectAs(): string;

    public function getBindings(): array;

    public function isHavingRequired(): bool;
}
