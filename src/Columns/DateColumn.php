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

    public function locale(string $locale): static
    {
        return $this->withMeta('locale', $locale);
    }

    public function formatOptions(string $year, string $month, string $day): static
    {
        return $this->withMeta('format_options', [
            'year' => $year,
            'month' => $month,
            'day' => $day,
        ]);
    }
}
