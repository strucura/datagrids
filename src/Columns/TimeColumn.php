<?php

namespace Strucura\Grids\Columns;

use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Enums\ColumnDataTypeEnum;

class TimeColumn extends AbstractColumn
{
    protected ColumnDataTypeEnum $dataType = ColumnDataTypeEnum::Time;
}
