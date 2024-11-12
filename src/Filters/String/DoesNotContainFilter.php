<?php

namespace Strucura\DataGrid\Filters\String;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;

class DoesNotContainFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterTypeEnum::DOES_NOT_CONTAIN;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = $column->getSelectAs().' NOT LIKE ?';
        $value = '%'.$filterData->value.'%';
        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method($expression, [...$column->getBindings(), $value]);

        return $query;
    }
}
