<?php

namespace Strucura\Grids\Data;

class SortData
{
    public function __construct(public string $column, public int $order) {}
}
