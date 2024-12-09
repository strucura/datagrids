<?php

namespace Strucura\DataGrid\FloatingFilters;

use Strucura\DataGrid\Abstracts\AbstractFloatingFilter;
use Strucura\DataGrid\Enums\FloatingFilterType;

class DateRangeFloatingFilter extends AbstractFloatingFilter
{
    protected FloatingFilterType|string $type = FloatingFilterType::DateRange;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs("DATE_FORMAT($selectAs, '%Y-%m-%d')");
    }
}
