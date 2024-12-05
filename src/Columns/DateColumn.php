<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

class DateColumn extends AbstractColumn
{
    protected ColumnTypeEnum $columnType = ColumnTypeEnum::Date;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs("DATE_FORMAT($selectAs, '%Y-%m-%d')");
    }

    /**
     * Provides instructions to the frontend on how to display the date
     *
     * @param string $dateFormat
     * @return $this
     */
    public function displayFormat(string $dateFormat): static
    {
        $this->withMeta('format', $dateFormat);

        return $this;
    }
}
