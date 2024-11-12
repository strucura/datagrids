<?php

namespace Strucura\DataGrid\Normalizers;

use Closure;
use Strucura\DataGrid\Contracts\NormalizerContract;

class BooleanNormalizer implements NormalizerContract
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
