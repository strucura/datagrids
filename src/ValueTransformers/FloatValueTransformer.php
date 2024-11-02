<?php

namespace Strucura\DataGrid\ValueTransformers;

use Closure;
use Strucura\DataGrid\Contracts\ValueTransformerContract;

class FloatValueTransformer implements ValueTransformerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        if (is_numeric($value) && str_contains($value, '.')) {
            $value = floatval($value);
        }

        return $next($value);
    }
}
