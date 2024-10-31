<?php

namespace Strucura\Grids\Columns;

use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Enums\ColumnTypeEnum;

class TimeColumn extends AbstractColumn
{
    protected ColumnTypeEnum $dataType = ColumnTypeEnum::Time;
}
