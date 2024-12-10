<?php

namespace Strucura\DataGrid\Data;

use Strucura\DataGrid\Enums\SortOperator;

class SortData
{
    public function __construct(public string $alias, public SortOperator $sortType) {}
}
