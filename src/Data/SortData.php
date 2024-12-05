<?php

namespace Strucura\DataGrid\Data;

use Strucura\DataGrid\Enums\SortOperator;

class SortData
{
    public function __construct(public string $column, public SortOperator $sortType) {}
}
