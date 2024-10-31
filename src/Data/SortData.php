<?php

namespace Strucura\Grids\Data;

use Strucura\Grids\Contracts\SortOrderEnum;

class SortData
{
    public function __construct(public string $column, public SortOrderEnum $order) {}
}
