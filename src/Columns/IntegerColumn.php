<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class IntegerColumn extends AbstractColumn
{
    protected ColumnType $columnType = ColumnType::Integer;

    public function signed(): static
    {
        return $this->setSelectAs('CAST('.$this->getSelectAs().' AS SIGNED)');
    }

    public function unsigned(): static
    {
        return $this->setSelectAs('CAST('.$this->getSelectAs().' AS UNSIGNED)');
    }
}
