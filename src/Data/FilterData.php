<?php

namespace Strucura\Grids\Data;

class FilterData
{
    public function __construct(
        public string $column,
        public mixed $value,
        public string $matchMode,
    ) {
        // Run through value transformers
    }
}
