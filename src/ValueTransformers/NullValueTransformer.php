<?php

namespace Strucura\DataGrid\ValueTransformers;

use Closure;
use Strucura\DataGrid\Contracts\ValueTransformerContract;

class NullValueTransformer implements ValueTransformerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        // If the value is a string, and it is 'null' or an empty string, then convert it to null
        if (is_string($value) && ($value == 'null' || $value == '')) {
            $value = null;
        }

        return $next($value);
    }
}
