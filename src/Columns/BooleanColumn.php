<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class BooleanColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Boolean;

    public function displayFormat(string $truthyFormat, string $falsyFormat): self
    {
        $this->withMeta('format', [
            'truthy' => $truthyFormat,
            'falsy' => $falsyFormat,
        ]);

        return $this;
    }
}
