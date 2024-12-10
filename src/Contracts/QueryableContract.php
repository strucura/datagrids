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
    /**
     * @param string $expression
     * @param string $alias
     * @param array $bindings
     */
    public function __construct(string $expression, string $alias, array $bindings = []);

    public static function make(Expression|string $expression, string $alias, array $bindings = []): QueryableContract;

    public function setExpression(string $expression): static;

    public function getExpression(): string;

    public function getAlias(): string;

    public function getBindings(): array;

    public function isHavingRequired(): bool;
}
