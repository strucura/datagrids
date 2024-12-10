<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class PointColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Point;

    protected bool $isFilterable = false;

    public function setExpression(string $expression): static
    {
        return parent::setExpression("CONCAT(ST_X($expression), ',', ST_Y($expression))");
    }
}
