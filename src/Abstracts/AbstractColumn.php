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

    protected bool $isHidden = false;

    protected array $meta = [];

    protected bool $sortable = true;

    protected bool $filterable = true;

    protected ColumnTypeEnum $columnType = ColumnTypeEnum::String;

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

    public static function make(Expression|string $queryColumn, string $alias): self
    {
        return new static($queryColumn, $alias);
    }

    public function getColumnType(): ColumnTypeEnum
    {
        return $this->columnType;
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
        $this->bindings->mergeBindings($builder instanceof EloquentBuilder ? $builder->getQuery() : $builder);

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
        foreach (['count(', 'sum(', 'avg(', 'min(', 'max('] as $expression) {
            if (str_contains(strtolower($this->selectAs), $expression)) {
                return true;
            }
        }

        return false;
    }

    public function hidden(): static
    {
        $this->isHidden = true;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'field' => $this->alias,
            'header' => $this->alias,
            'column_type' => $this->columnType,
            'sortable' => $this->sortable,
            'filterable' => $this->filterable,
            'hidden' => $this->isHidden,
            'meta' => $this->meta,
        ];
    }
}
