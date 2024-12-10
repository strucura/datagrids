<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Expression;

/**
 * This contract is used to define the requirements for a queryable expression.  This is used to define the select
 * columns and aliases for the data grid. Additionally, it is used to define floating filters and their aliases to allow
 * for the data grid to be able to filter based upon values that are not directly in the data grid.
 */
interface QueryableContract
{
    public function __construct(string $expression, string $alias, array $bindings = []);

    /**
     * Create a new instance of a queryable expression
     *
     * @param Expression|string $expression
     * @param string $alias
     * @param array $bindings
     * @return QueryableContract
     */
    public static function make(Expression|string $expression, string $alias, array $bindings = []): QueryableContract;

    /**
     * Used to set the expression for the queryable expression
     *
     * @param string $expression
     * @return QueryableContract
     */
    public function setExpression(string $expression): static;

    /**
     * Used to get the expression for the queryable expression
     *
     * @return string
     */
    public function getExpression(): string;

    /**
     * The alias for the queryable expression
     *
     * @return string
     */
    public function getAlias(): string;

    /**
     * Get the bindings for the queryable expression
     *
     * @return array
     */
    public function getBindings(): array;

    /**
     * Determine if the queryable expression must be used in a having clause.
     *
     * @return bool
     */
    public function isHavingRequired(): bool;
}
