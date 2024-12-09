<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class StringColumn extends AbstractColumn
{
    protected ColumnType $columnType = ColumnType::String;
}
