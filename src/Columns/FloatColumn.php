<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class FloatColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Float;

    public function setExpression(string $expression): static
    {
        return parent::setExpression('CAST('.$expression.' AS FLOAT)');
    }
}
