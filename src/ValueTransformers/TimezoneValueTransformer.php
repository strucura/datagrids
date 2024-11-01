<?php

namespace Strucura\DataGrid\ValueTransformers;

use Closure;
use Strucura\DataGrid\Contracts\ValueTransformerContract;

class TimezoneValueTransformer implements ValueTransformerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        return $next($value);
    }
}
