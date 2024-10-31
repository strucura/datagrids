<?php

namespace Strucura\Grids\Data;

use Strucura\Grids\Enums\FilterMatchModeEnum;

class FilterData
{
    public function __construct(
        public string $column,
        public mixed $value,
        public FilterMatchModeEnum $matchMode,
    ) {
        // Run through value transformers
    }
}
