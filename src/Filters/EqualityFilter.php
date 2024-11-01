<?php

namespace Strucura\DataGrid\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;

class EqualityFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::EQUALS,
            FilterTypeEnum::IS,
            FilterTypeEnum::NOT_EQUALS,
            FilterTypeEnum::IS_NOT,
        ]) && $this->getTransformedFilterValue($filterData->value) !== null;
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->filterType) {
            FilterTypeEnum::EQUALS => $column->getSelectAs().' = ?',
            FilterTypeEnum::NOT_EQUALS => $column->getSelectAs().' != ?',
            default => throw new \Exception('Invalid match mode for equality filter'),
        };

        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method($expression, [...$column->getBindings(), $filterData->value]);

        return $query;
    }
}
