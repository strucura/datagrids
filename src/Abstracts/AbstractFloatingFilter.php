<?php

namespace Strucura\DataGrid\Abstracts;

use Strucura\DataGrid\Contracts\FloatingFilterContract;
use Strucura\DataGrid\Enums\FloatingFilterType;
use Strucura\DataGrid\Traits\HandlesMetaData;
use Strucura\DataGrid\Traits\HandlesQueryCreation;

abstract class AbstractFloatingFilter implements FloatingFilterContract
{
    use HandlesMetaData, HandlesQueryCreation;

    /**
     * Conveys the type of floating filter, which is useful for the front end to understand how to present the filter.
     */
    protected FloatingFilterType|string $type;

    public function toArray(): array
    {
        return [
            'alias' => $this->getAlias(),
            'type' => $this->type,
            'meta' => $this->meta,
        ];
    }
}
