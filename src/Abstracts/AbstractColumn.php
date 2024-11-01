<?php

namespace Strucura\DataGrid\Abstracts;

use Exception;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Traits\Macroable;
use Strucura\DataGrid\Contracts\ColumnContract;
use Strucura\DataGrid\Enums\ColumnTypeEnum;

abstract class AbstractColumn implements ColumnContract
{
    use Macroable;

    protected QueryBuilder $bindings;

    protected string $selectAs;

    protected string $alias;

    protected string $queryColumn;

    /**
     * We are disabling this by default because we are not implementing sorting yet. When implemented, it will be
     * true by default.
     *
     * @var bool Whether the column is sortable
     */
    protected bool $sortable = true;

    /**
     * We are disabling this by default because we are not implementing filtering yet.  When implemented, it will be
     * true by default.
     *
     * @var bool Whether the column is filterable
     */
    protected bool $filterable = true;

    /**
     * The data type of the column. We are using this to convey the format to the front end so that they can easily
     * determine how best to present the data.  Ex: Converting a date time to the user's timezone
     */
    protected ColumnTypeEnum $dataType = ColumnTypeEnum::String;

    /**
     * @throws Exception
     */
    public function __construct(string $queryColumn, string $alias)
    {
        $this->alias = $alias;
        $this->bindings = DB::query();

        if (! empty($queryColumn) && ! preg_match('/^\w+?\.\w+?$/', $queryColumn)) {
            throw new Exception("Query column '$queryColumn' should be formatted as \"table_name.column_name\".");
        }

        $this->queryColumn = $queryColumn;
        $this->setSelectAs($queryColumn);
    }

    /**
     * @throws Exception
     */
    public static function make(Expression|string $queryColumn, string $alias): self
    {
        return new static($queryColumn, $alias);
    }

    public function addBinding($value): self
    {
        $this->bindings->addBinding($value);

        return $this;
    }

    public function getBindings(): array
    {
        return $this->bindings->getBindings();
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setSelectAs(string $selectAs): static
    {
        $this->selectAs = $selectAs;

        return $this;
    }

    public function getSelectAs(): string
    {
        return $this->selectAs;
    }

    public function selectAsSubQuery(QueryBuilder|EloquentBuilder $builder): static
    {
        if ($builder instanceof EloquentBuilder) {
            $this->bindings->mergeBindings($builder->getQuery());
        } else {
            $this->bindings->mergeBindings($builder);
        }

        return $this->setSelectAs("({$builder->toSql()})");
    }

    public function withoutSorting(): static
    {
        $this->sortable = false;

        return $this;
    }

    public function withoutFiltering(): static
    {
        $this->filterable = false;

        return $this;
    }

    public function isHavingRequired(): bool
    {
        $groupingExpressions = ['count(', 'sum(', 'avg(', 'min(', 'max('];

        foreach ($groupingExpressions as $expression) {
            if (str_contains(strtolower($this->selectAs), $expression)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Convert the column definition to an array.  This is useful for helping us later easily convey the definition of
     * the column to front end components.
     */
    public function toArray(): array
    {
        return [
            'field' => $this->alias,
            'header' => $this->alias,
            'data_type' => $this->dataType,
            'sortable' => $this->sortable,
            'filterable' => $this->filterable,
        ];
    }
}
