<?php

namespace Strucura\DataGrid\Filters\Numeric;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;

class LessThanFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterTypeEnum::LESS_THAN;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = $column->getSelectAs().' < ?';
        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method($expression, [...$column->getBindings(), $filterData->value]);

        return $query;
    }
}
