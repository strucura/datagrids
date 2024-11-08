<?php

namespace Strucura\DataGrid\Data;

use Strucura\DataGrid\Enums\FilterTypeEnum;

class FilterData
{
    public function __construct(
        public string $column,
        public mixed $value,
        public FilterTypeEnum $filterType,
    ) {}
}
