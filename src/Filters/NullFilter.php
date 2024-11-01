<?php

namespace Strucura\DataGrid\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Contracts\FilterContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;

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
