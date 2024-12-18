<?php

namespace Strucura\DataGrid\Contracts;

use Closure;

/**
 * The NormalizerContract is a contract for normalizing values which will be applied to the data grid as filters.
 */
interface NormalizerContract
{
    public function handle(mixed $value, Closure $next): mixed;
}
