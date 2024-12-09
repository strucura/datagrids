<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Expression;

interface QueryableContract
{
    public function __construct(string $selectAs, string $alias, array $bindings = []);

    public static function make(Expression|string $queryColumn, string $alias, array $bindings = []): QueryableContract;

    public function getSelectAs(): string;

    public function getAlias(): string;

    public function getBindings(): array;

    public function isHavingRequired(): bool;
}
