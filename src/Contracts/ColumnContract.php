<?php

namespace Strucura\DataGrid\Contracts;

interface ColumnContract extends QueryableContract
{
    public function toArray(): array;
}
