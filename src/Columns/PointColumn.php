<?php

namespace Strucura\Grids\Columns;

use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Enums\ColumnTypeEnum;

class PointColumn extends AbstractColumn
{
    protected ColumnTypeEnum $dataType = ColumnTypeEnum::Point;

    protected bool $filterable = false;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs("CONCAT(ST_X($selectAs), ',', ST_Y($selectAs))");
    }
}
