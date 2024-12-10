<?php

namespace Strucura\DataGrid\Data;

use Strucura\DataGrid\Enums\FilterOperator;

class FilterData
{
    public function __construct(
        public string $alias,
        public mixed $value,
        public FilterOperator $filterType,
        public array $conditions = []
    ) {}
}
