<?php

namespace Strucura\DataGrid\Normalizers;

use Closure;
use Strucura\DataGrid\Contracts\NormalizerContract;

class FloatNormalizer implements NormalizerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        if (is_numeric($value) && str_contains($value, '.')) {
            $value = floatval($value);
        }

        return $next($value);
    }
}
