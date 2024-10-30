<?php

namespace Strucura\Grids\ValueTransformers;

use Closure;
use Strucura\Grids\Contracts\ValueTransformerContract;

class BooleanValueTransformer implements ValueTransformerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        if ($value === 'true' || $value === 'on') {
            $value = true;
        } elseif ($value === 'false' || $value === 'off') {
            $value = false;
        }

        return $next($value);
    }
}
