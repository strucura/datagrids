<?php

namespace Strucura\Grids\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\Grids\Abstracts\AbstractColumn;
use Strucura\Grids\Abstracts\AbstractFilter;
use Strucura\Grids\Contracts\FilterContract;
use Strucura\Grids\Data\FilterData;
use Strucura\Grids\Enums\FilterTypeEnum;

class NullFilter extends AbstractFilter implements FilterContract
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $this->getTransformedFilterValue($filterData->value) === null;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = $column->getSelectAs().($filterData->value === FilterTypeEnum::EQUALS ? ' IS NULL' : ' IS NOT NULL');

        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method($expression, [...$column->getBindings(), $filterData->value]);

        return $query;
    }
}
