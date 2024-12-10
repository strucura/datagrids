<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class DateColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Date;

    public function setExpression(string $expression): static
    {
        return parent::setExpression("DATE_FORMAT($expression, '%Y-%m-%d')");
    }

    /**
     * Provides instructions to the frontend on how to display the date
     *
     * @return $this
     */
    public function displayFormat(string $dateFormat): static
    {
        $this->withMeta('format', $dateFormat);

        return $this;
    }
}
