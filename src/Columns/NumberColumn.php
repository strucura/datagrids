<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class NumberColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Number;
}
