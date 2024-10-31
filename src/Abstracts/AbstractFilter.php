<?php

namespace Strucura\Grids\Abstracts;

use Illuminate\Pipeline\Pipeline;
use Strucura\Grids\Contracts\FilterContract;

abstract class AbstractFilter implements FilterContract
{
    public function prepareFilterValueForDatabase(mixed $value): mixed
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
