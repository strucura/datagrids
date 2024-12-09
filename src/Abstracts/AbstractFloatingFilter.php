<?php

namespace Strucura\DataGrid\Abstracts;

use Strucura\DataGrid\Enums\FloatingFilterType;
use Strucura\DataGrid\Traits\HandlesMetaData;
use Strucura\DataGrid\Traits\HandlesQueryCreation;

abstract class AbstractFloatingFilter
{
    use HandlesMetaData, HandlesQueryCreation;

    /**
     * Conveys the type of floating filter, which is useful for the front end to understand how to present the filter.
     */
    protected FloatingFilterType|string $type;

    public function toArray(): array
    {
        return [
            'name' => $this->getAlias(),
            'type' => $this->type,
            'meta' => $this->meta,
        ];
    }
}
