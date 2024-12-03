<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

class DateTimeColumn extends AbstractColumn
{
    protected ColumnTypeEnum $columnType = ColumnTypeEnum::DateTime;

    public function setSelectAs(string $selectAs): static
    {
        return parent::setSelectAs("DATE_FORMAT($selectAs, '%Y-%m-%d %T')");
    }
}
