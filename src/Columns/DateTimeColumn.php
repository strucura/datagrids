<?php

namespace Strucura\DataGrid\Columns;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Enums\ColumnType;

class DateTimeColumn extends AbstractColumn
{
    protected ColumnType|string $columnType = ColumnType::DateTime;

    public function setExpression(string $expression): static
    {
        return parent::setExpression("DATE_FORMAT($expression, '%Y-%m-%d %T')");
    }

    public function locale(string $locale): static
    {
        return $this->withMeta('locale', $locale);
    }

    public function formatOptions(string $year, string $month, string $day, string $hour, string $minute, string $second): static
    {
        return $this->withMeta('format_options', [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'hour' => $hour,
            'minute' => $minute,
            'second' => $second,
        ]);
    }
}
