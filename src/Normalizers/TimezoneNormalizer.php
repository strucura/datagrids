<?php

namespace Strucura\DataGrid\Normalizers;

use Closure;
use Illuminate\Support\Carbon;
use Strucura\DataGrid\Contracts\NormalizerContract;

class TimezoneNormalizer implements NormalizerContract
{
    public function handle(mixed $value, Closure $next): mixed
    {
        $pattern = '/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:Z|[+-]\d{2}:\d{2})/';
        // If it matches the ISO-8601 pattern and is a valid date time.
        if (preg_match($pattern, $value, $matches) && strtotime($value) !== false) {
            $value = Carbon::parse($value)
                ->setTimezone(config('app.timezone'))
                ->format('Y-m-d H:i:s');

            return $next($value);
        }

        return $next($value);
    }
}
