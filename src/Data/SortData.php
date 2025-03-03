<?php

namespace Strucura\DataGrid\Data;

use Strucura\DataGrid\Enums\SortOperator;

class SortData
{
    /**
     * The column alias
     */
    public function __construct(public string $alias, public SortOperator $sortOperator) {}

    /**
     * Create a new instance of the class
     */
    public static function make(string $alias, SortOperator $sortOperator): self
    {
        return new self($alias, $sortOperator);
    }

    /**
     * Convert the class to an array
     */
    public function toArray(): array
    {
        return [
            'alias' => $this->alias,
            'sortOperator' => $this->sortOperator->value,
        ];
    }
}
