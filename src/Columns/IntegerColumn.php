<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class IntegerColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Integer;

    public function signed(): static
    {
        return $this->setExpression('CAST('.$this->getExpression().' AS SIGNED)');
    }

    public function unsigned(): static
    {
        return $this->setExpression('CAST('.$this->getExpression().' AS UNSIGNED)');
    }
}
