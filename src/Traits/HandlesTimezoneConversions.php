<?php

namespace Strucura\DataGrid\Traits;

use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Columns\DateColumn;
use Strucura\DataGrid\Columns\DateTimeColumn;

trait HandlesTimezoneConversions
{
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

    abstract public function setExpression(string $expression): static;
}
