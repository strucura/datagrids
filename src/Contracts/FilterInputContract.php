<?php

namespace Strucura\DataGrid\Contracts;

/**
 * Used to define a filter input which is a filter that is not directly associated with a column.
 */
interface FilterInputContract extends QueryableContract
{
    public function toArray(): array;
}
