<?php

namespace Strucura\Grids\Columns;

use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Enums\ColumnDataTypeEnum;

class DateColumn extends AbstractColumn
{
    protected ColumnDataTypeEnum $dataType = ColumnDataTypeEnum::Date;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs("DATE_FORMAT($selectAs, '%Y-%m-%d')");
    }
}
