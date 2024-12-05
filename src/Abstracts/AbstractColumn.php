<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Traits\Macroable;
use Strucura\DataGrid\Contracts\ColumnContract;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

abstract class AbstractColumn implements ColumnContract
{
    use Macroable;

    /**
     * The query builder parameter bindings to be used for the column
     */
    protected QueryBuilder $bindings;

    /**
     * The SQL select expression for the column
     */
    protected string $selectAs;

    /**
     * How we want to name the column
     */
    protected string $columnName;

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
    protected ColumnTypeEnum $columnType = ColumnTypeEnum::String;

    /**
     * Miscellaneous metadata that can be used to store additional information about the column
     */
    protected array $meta = [];

    /**
     * AbstractColumn constructor.
     */
    public function __construct(string $selectAs, string $alias, array $bindings = [])
    {
        $this->columnName = $alias;
        $this->bindings = DB::query();

        $this->setSelectAs($selectAs);

        foreach ($bindings as $binding) {
            $this->addBinding($binding);
        }
    }

    /**
     * Create a new instance of the column
     */
    public static function make(Expression|string $queryColumn, string $alias, array $bindings = []): self
    {
        return new static($queryColumn, $alias, $bindings);
    }

    /**
     * Get the column type
     */
    public function getColumnType(): ColumnTypeEnum
    {
        return $this->columnType;
    }

    /**
     * Add a binding to the column
     */
    public function addBinding(mixed $value): self
    {
        $this->bindings->addBinding($value);

        return $this;
    }

    public function getBindings(): array
    {
        return $this->bindings->getBindings();
    }

    /**
     * Get the alias for the column
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * Set the select expression for the column.
     *
     * @return $this
     */
    public function setSelectAs(string $selectAs): static
    {
        $this->selectAs = $selectAs;

        return $this;
    }

    /**
     * Get the select expression for the column
     */
    public function getSelectAs(): string
    {
        return $this->selectAs;
    }

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

    public function withMeta(string $key, mixed $value): static
    {
        $this->meta[$key] = $value;

        return $this;
    }

    /**
     * Set the column type
     */
    public function isHavingRequired(): bool
    {
        foreach (['count(', 'sum(', 'avg(', 'min(', 'max('] as $expression) {
            if (str_contains(strtolower($this->selectAs), $expression)) {
                return true;
            }
        }

        return false;
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
            'name' => $this->columnName,
            'type' => $this->columnType,
            'is_sortable' => $this->isSortable,
            'is_filterable' => $this->isFilterable,
            'is_hidden' => $this->isHidden,
            'meta' => $this->meta,
        ];
    }
}
