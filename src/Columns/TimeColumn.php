<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class TimeColumn extends AbstractColumn
{
    protected ColumnType $columnType = ColumnType::Time;

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
