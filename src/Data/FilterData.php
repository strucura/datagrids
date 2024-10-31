<?php

namespace Strucura\Grids\Data;

use Strucura\Grids\Enums\FilterTypeEnum;

class FilterData
{
    public function __construct(
        public string         $column,
        public mixed          $value,
        public FilterTypeEnum $filterType,
    ) {
        // Run through value transformers
    }
}
