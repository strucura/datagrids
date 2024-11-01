<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Pipeline\Pipeline;
use Strucura\DataGrid\Contracts\FilterContract;

abstract class AbstractFilter implements FilterContract
{
    public function getTransformedFilterValue(mixed $value): mixed
    {
        $transformers = config('grids.value_transformers');

        foreach ($transformers as $transformer) {
            /** @var Pipeline $pipeline */
            $pipeline = app(Pipeline::class);
            $value = $pipeline->send($transformer->value)
                ->through($transformers)
                ->thenReturn();
        }

        return $value;
    }
}
