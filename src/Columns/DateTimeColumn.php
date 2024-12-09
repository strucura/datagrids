<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class DateTimeColumn extends AbstractColumn
{
    protected ColumnType $columnType = ColumnType::DateTime;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs("DATE_FORMAT($selectAs, '%Y-%m-%d %T')");
    }

    /**
     * Provides instructions to the frontend on how to display the date time
     *
     * @param string $format
     * @return $this
     */
    public function displayFormat(string $format): static
    {
        $this->withMeta('format', $format);

        return $this;
    }
}
