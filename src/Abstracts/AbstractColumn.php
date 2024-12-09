<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Support\Traits\Macroable;
use Strucura\DataGrid\Contracts\ColumnContract;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Traits\HandlesMetaData;
use Strucura\DataGrid\Traits\HandlesQueryExpressions;

abstract class AbstractColumn implements ColumnContract
{
    use HandlesMetaData, HandlesQueryExpressions, Macroable;

    /**
     * Whether we want to hide the column in the grid.  This is useful for columns that you may want exposed to the
     * user, but not visible by default.
     */
    protected bool $isHidden = false;

    /**
     * Whether the column is sortable
     */
    protected bool $isSortable = true;

    /**
     * Whether the column is filterable
     */
    protected bool $isFilterable = true;

    /**
     * The type of column.  This is useful for the front end so that they understand how to present the data and what
     * filters are available.
     */
    protected ColumnType|string $columnType = ColumnType::String;

    /**
     * Set the column type
     *
     * @return $this
     */
    public function withoutSorting(): static
    {
        $this->isSortable = false;

        return $this;
    }

    /**
     * Set the column type
     *
     * @return $this
     */
    public function withoutFiltering(): static
    {
        $this->isFilterable = false;

        return $this;
    }

    /**
     * Set the column type
     *
     * @return $this
     */
    public function hidden(): static
    {
        $this->isHidden = true;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'alias' => $this->getAlias(),
            'type' => $this->columnType,
            'is_sortable' => $this->isSortable,
            'is_filterable' => $this->isFilterable,
            'is_hidden' => $this->isHidden,
            'meta' => $this->meta,
        ];
    }
}
