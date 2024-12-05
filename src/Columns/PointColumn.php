<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

class PointColumn extends AbstractColumn
{
    protected ColumnTypeEnum $columnType = ColumnTypeEnum::Point;

    protected bool $isFilterable = false;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs("CONCAT(ST_X($selectAs), ',', ST_Y($selectAs))");
    }
}
