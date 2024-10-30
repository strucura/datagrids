<?php

namespace Strucura\Grids\Columns;

use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Enums\ColumnDataTypeEnum;

class NumberColumn extends AbstractColumn
{
    protected ColumnDataTypeEnum $dataType = ColumnDataTypeEnum::Number;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs('CAST('.$selectAs.' AS UNSIGNED)');
    }
}
