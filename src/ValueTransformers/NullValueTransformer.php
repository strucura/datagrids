<?php

namespace Strucura\Grids\ValueTransformers;

use Closure;
use Strucura\Grids\Contracts\ValueTransformerContract;

class NullValueTransformer implements ValueTransformerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        if (is_string($value) && $value == 'null') {
            $value = null;
        }

        return $next($value);
    }
}
