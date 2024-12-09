<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class PointColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Point;

    protected bool $isFilterable = false;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs("CONCAT(ST_X($selectAs), ',', ST_Y($selectAs))");
    }
}
