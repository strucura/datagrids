<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class NumberColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Number;

    public function float(): static
    {
        return $this->setExpression('CAST('.$this->getExpression().' AS FLOAT)');
    }

    public function signed(): static
    {
        return $this->setExpression('CAST('.$this->getExpression().' AS SIGNED)');
    }

    public function unsigned(): static
    {
        return $this->setExpression('CAST('.$this->getExpression().' AS UNSIGNED)');
    }
}
