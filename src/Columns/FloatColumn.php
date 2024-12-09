<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class FloatColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Float;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs('CAST('.$selectAs.' AS FLOAT)');
    }
}
