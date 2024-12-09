<?php

namespace Strucura\DataGrid\Traits;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

trait HandlesQueryCreation
{
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
    protected string $alias;

    /**
     * AbstractColumn constructor.
     */
    final public function __construct(string $selectAs, string $alias, array $bindings = [])
    {
        $this->alias = $alias;
        $this->bindings = DB::query();

        $this->setSelectAs($selectAs);

        foreach ($bindings as $binding) {
            $this->addBinding($binding);
        }
    }

    /**
     * Create a new instance of the column
     */
    final public static function make(Expression|string $queryColumn, string $alias, array $bindings = []): self
    {
        return new static($queryColumn, $alias, $bindings);
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
    public function getAlias(): string
    {
        return $this->alias;
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
}
