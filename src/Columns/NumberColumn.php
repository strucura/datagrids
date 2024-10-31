<?php

namespace Strucura\Grids\Columns;

use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Enums\ColumnTypeEnum;

class NumberColumn extends AbstractColumn
{
    protected ColumnTypeEnum $dataType = ColumnTypeEnum::Number;

    public function asFloat(): static
    {
        return $this->setSelectAs('CAST('.$this->getSelectAs().' AS FLOAT)');
    }

    public function asInteger(): static
    {
        return $this->setSelectAs('CAST('.$this->getSelectAs().' AS SIGNED)');
    }

    public function asUnsignedInteger(): static
    {
        return $this->setSelectAs('CAST('.$this->getSelectAs().' AS UNSIGNED)');
    }
}
