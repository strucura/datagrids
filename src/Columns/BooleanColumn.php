<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

class BooleanColumn extends AbstractColumn
{
    protected ColumnTypeEnum $columnType = ColumnTypeEnum::Boolean;

    public function displayFormat(string $truthyFormat, string $falsyFormat): self
    {
        $this->withMeta('format', [
            'truthy' => $truthyFormat,
            'falsy' => $falsyFormat,
        ]);

        return $this;
    }
}
