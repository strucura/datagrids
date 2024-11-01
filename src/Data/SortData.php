<?php

namespace Strucura\DataGrid\Data;

use Strucura\DataGrid\Enums\SortTypeEnum;

class SortData
{
    public function __construct(public string $column, public SortTypeEnum $sortType) {}
}
