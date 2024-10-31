<?php

namespace Strucura\Grids\Contracts;

use Closure;

interface ValueTransformerContract
{
    public function handle(mixed $value, Closure $next): mixed;
}
