<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class TimeColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::Time;

    public function locale(string $locale): static
    {
        return $this->withMeta('locale', $locale);
    }

    public function formatOptions(string $hour, string $minute, string $second): static
    {
        return $this->withMeta('format_options', [
            'hour' => $hour,
            'minute' => $minute,
            'second' => $second,
        ]);
    }
}
