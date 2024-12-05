<?php

namespace Strucura\DataGrid\Data;

use Illuminate\Support\Collection;
use Strucura\DataGrid\Enums\FilterSetOperator;

class FilterSetData
{
    public function __construct(
        public ?Collection $filters = null,
        public FilterSetOperator $filterOperator = FilterSetOperator::AND
    ) {
        if ($this->filters === null) {
            $this->filters = new Collection;
        }
    }
}
