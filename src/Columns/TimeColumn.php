<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

class TimeColumn extends AbstractColumn
{
    protected ColumnTypeEnum $columnType = ColumnTypeEnum::Time;

    /**
     * Provides instructions to the frontend on how to display the time
     *
     * @return $this
     */
    public function displayFormat(string $displayFormat): static
    {
        $this->withMeta('format', $displayFormat);

        return $this;
    }
}
