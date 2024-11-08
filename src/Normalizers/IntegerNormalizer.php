<?php

namespace Strucura\DataGrid\Normalizers;

use Closure;
use Strucura\DataGrid\Contracts\NormalizerContract;

class IntegerNormalizer implements NormalizerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        if (is_numeric($value) && ! str_contains($value, '.')) {
            $value = intval($value);
        }

        return $next($value);
    }
}
