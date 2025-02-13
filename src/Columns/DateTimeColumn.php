<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Traits\HandlesTimezoneConversions;

class DateTimeColumn extends AbstractColumn
{
    use HandlesTimezoneConversions;

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
