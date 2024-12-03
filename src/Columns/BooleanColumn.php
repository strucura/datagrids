<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

class BooleanColumn extends AbstractColumn
{
    protected ColumnTypeEnum $columnType = ColumnTypeEnum::Boolean;
}
