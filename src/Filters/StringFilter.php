<?php

namespace Strucura\DataGrid\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;

class StringFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::STARTS_WITH,
            FilterTypeEnum::ENDS_WITH,
            FilterTypeEnum::CONTAINS,
            FilterTypeEnum::NOT_CONTAINS,
        ]);
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->filterType) {
            FilterTypeEnum::STARTS_WITH, FilterTypeEnum::ENDS_WITH, FilterTypeEnum::CONTAINS => $column->getSelectAs().' LIKE ?',
            FilterTypeEnum::NOT_CONTAINS => $column->getSelectAs().' NOT LIKE ?',
            default => throw new \Exception('Invalid match mode for string filter'),
        };

        $value = match ($filterData->filterType) {
            FilterTypeEnum::STARTS_WITH => $filterData->value.'%',
            FilterTypeEnum::ENDS_WITH => '%'.$filterData->value,
            FilterTypeEnum::CONTAINS, FilterTypeEnum::NOT_CONTAINS => '%'.$filterData->value.'%',
            default => throw new \Exception('Invalid match mode for string filter'),
        };

        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method($expression, [...$column->getBindings(), $value]);

        return $query;
    }
}
