<?php

namespace Strucura\DataGrid\Abstracts;

use Illuminate\Pipeline\Pipeline;
use Strucura\DataGrid\Contracts\FilterContract;
use Strucura\DataGrid\Enums\FilterSetOperator;

abstract class AbstractFilter implements FilterContract
{
    /**
     * Normalize the value before using it in the query.
     */
    public function getNormalizedValue(mixed $value): mixed
    {
        $normalizers = config('datagrids.normalizers');

        /** @var Pipeline $pipeline */
        $pipeline = app(Pipeline::class);

        return $pipeline->send($value)
            ->through($normalizers)
            ->thenReturn();
    }

    /**
     * Get the query method to be used in the query builder.
     */
    public function getQueryMethod(AbstractColumn $column, FilterSetOperator $filterSetOperator): string
    {
        $queryMethod = $column->isHavingRequired()
            ? 'havingRaw'
            : 'whereRaw';

        if ($filterSetOperator === FilterSetOperator::OR) {
            $queryMethod = 'or'.ucfirst($queryMethod);
        }

        return $queryMethod;
    }
}
