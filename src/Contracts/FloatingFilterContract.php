<?php

namespace Strucura\DataGrid\Contracts;

interface FloatingFilterContract extends QueryableContract
{
    public function toArray(): array;
}
