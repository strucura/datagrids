<?php

namespace Strucura\DataGrid\Contracts;

/**
 * Used to define a floating filter which is a filter that is not directly associated with a column.
 */
interface FloatingFilterContract extends QueryableContract
{
    public function toArray(): array;
}
