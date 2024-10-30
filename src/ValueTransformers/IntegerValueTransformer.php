<?php

namespace Strucura\Grids\ValueTransformers;

use Closure;
use Strucura\Grids\Contracts\ValueTransformerContract;

class IntegerValueTransformer implements ValueTransformerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        if (is_numeric($value) && ! str_contains($value, '.')) {
            $value = intval($value);
        }

        return $next($value);
    }
}
