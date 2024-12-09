<?php

namespace Strucura\DataGrid\FloatingFilters;

use Strucura\DataGrid\Abstracts\AbstractFloatingFilter;
use Strucura\DataGrid\Enums\FloatingFilterType;

class DateRangeFloatingFilter extends AbstractFloatingFilter
{
    protected FloatingFilterType $type = FloatingFilterType::DateRange;
}
