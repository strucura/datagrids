<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Pipeline\Pipeline;
use Strucura\DataGrid\Contracts\FilterContract;

abstract class AbstractFilter implements FilterContract
{
    public function getNormalizedValue(mixed $value): mixed
    {
        $normalizers = config('datagrids.normalizers');

        /** @var Pipeline $pipeline */
        $pipeline = app(Pipeline::class);

        return $pipeline->send($value)
            ->through($normalizers)
            ->thenReturn();
    }
}
