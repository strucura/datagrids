<?php

namespace Strucura\Grids\Data;

use Strucura\Grids\Enums\SortTypeEnum;

class SortData
{
    public function __construct(public string $column, public SortTypeEnum $sortType) {}
}
