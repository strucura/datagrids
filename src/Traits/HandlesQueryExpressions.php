<?php

namespace Strucura\DataGrid\Traits;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

trait HandlesQueryExpressions
{
    /**
     * The query builder parameter bindings to be used for the column
     */
    protected QueryBuilder $bindings;

    /**
     * The SQL select expression for the column
     */
    protected string $expression;

    /**
     * How we want to name the column
     */
    protected string $alias;

    /**
     * AbstractColumn constructor.
     */
    public function __construct(string $expression, string $alias, array $bindings = [])
    {
        $this->alias = $alias;
        $this->bindings = DB::query();

        $this->setExpression($expression);

        foreach ($bindings as $binding) {
            $this->addBinding($binding);
        }
    }

    /**
     * Create a new instance of the column
     */
    public static function make(Expression|string $expression, string $alias, array $bindings = []): self
    {
        return new static($expression, $alias, $bindings);
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
    public function setExpression(string $expression): static
    {
        $this->expression = $expression;

        return $this;
    }

    /**
     * Get the select expression for the column
     */
    public function getExpression(): string
    {
        return $this->expression;
    }

    /**
     * Set the column type
     */
    public function isHavingRequired(): bool
    {
        foreach (['count(', 'sum(', 'avg(', 'min(', 'max('] as $expression) {
            if (str_contains(strtolower($this->expression), $expression)) {
                return true;
            }
        }

        return false;
    }
}
