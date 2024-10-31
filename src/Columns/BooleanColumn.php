<?php

namespace Strucura\Grids\Columns;

use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Enums\ColumnTypeEnum;

class BooleanColumn extends AbstractColumn
{
    protected ColumnTypeEnum $dataType = ColumnTypeEnum::Boolean;
}
