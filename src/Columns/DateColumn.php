<?php

namespace Strucura\DataGrid\Columns;

use Illuminate\Support\Facades\Context;
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

    /**
     * Handles the conversion of the date to a different timezone
     *
     * @throws \Exception
     */
    public function toTimezone(string $timezone): static
    {
        if (!in_array($timezone, timezone_identifiers_list())) {
            throw new \Exception("Invalid timezone: $timezone");
        }

        // If the timezone is the same as the app timezone, we don't need to convert
        $this->setExpression("CONVERT_TZ($this->expression, ?, ?)")
            ->addBinding(config('app.timezone') ?? 'UTC')
            ->addBinding($timezone);

        return $this;
    }
}
