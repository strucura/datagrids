<?php

namespace Strucura\DataGrid\FilterInputs;

use Strucura\DataGrid\Abstracts\AbstractFilterInput;
use Strucura\DataGrid\Enums\FloatingFilterType;

class DateRangeFilterInput extends AbstractFilterInput
{
    protected FloatingFilterType|string $type = FloatingFilterType::DateRange;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setExpression("DATE_FORMAT($selectAs, '%Y-%m-%d')");
    }
}
