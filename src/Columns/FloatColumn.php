<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

class FloatColumn extends AbstractColumn
{
    protected ColumnTypeEnum $columnType = ColumnTypeEnum::Float;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs('CAST('.$selectAs.' AS FLOAT)');
    }
}
