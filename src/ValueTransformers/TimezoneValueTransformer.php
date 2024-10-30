<?php

namespace Strucura\Grids\ValueTransformers;

use Closure;
use Strucura\Grids\Contracts\ValueTransformerContract;

class TimezoneValueTransformer implements ValueTransformerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        return $next($value);
    }
}
