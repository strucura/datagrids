<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Support\Traits\Macroable;
use Strucura\DataGrid\Contracts\FilterInputContract;
use Strucura\DataGrid\Enums\FloatingFilterType;
use Strucura\DataGrid\Traits\HandlesMetaData;
use Strucura\DataGrid\Traits\HandlesQueryExpressions;

abstract class AbstractFilterInput implements FilterInputContract
{
    use HandlesMetaData, HandlesQueryExpressions, Macroable;

    /**
     * Conveys the type of filter inputs, which is useful for the front end to understand how to present the filter.
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
