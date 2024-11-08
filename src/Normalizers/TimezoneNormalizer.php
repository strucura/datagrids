<?php

namespace Strucura\DataGrid\Normalizers;

use Closure;
use Strucura\DataGrid\Contracts\NormalizerContract;

class TimezoneNormalizer implements NormalizerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        return $next($value);
    }
}
