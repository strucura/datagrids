<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class DateTimeColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::DateTime;

    /**
     * Provides instructions to the frontend on how to display the date time
     *
     * @return $this
     */
    public function displayFormat(string $format): static
    {
        $this->withMeta('format', $format);

        return $this;
    }
}
