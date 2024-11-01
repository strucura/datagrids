<?php

namespace Strucura\DataGrid\Filters;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;

class DateFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return in_array($filterData->filterType, [
            FilterTypeEnum::DATE_IS,
            FilterTypeEnum::DATE_IS_NOT,
            FilterTypeEnum::BEFORE,
            FilterTypeEnum::DATE_BEFORE,
            FilterTypeEnum::AFTER,
            FilterTypeEnum::DATE_AFTER,
            FilterTypeEnum::DOESNT_HAVE,
        ]);
    }

    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData): Builder
    {
        $expression = match ($filterData->filterType) {
            FilterTypeEnum::DATE_IS => "{$column->getSelectAs()} = DATE_FORMAT(?, '%Y-%m-%d %T')",
            FilterTypeEnum::AFTER, FilterTypeEnum::DATE_AFTER => "{$column->getSelectAs()} > DATE_FORMAT(?, '%Y-%m-%d %T')",
            FilterTypeEnum::BEFORE, FilterTypeEnum::DATE_BEFORE => "{$column->getSelectAs()} < DATE_FORMAT(?, '%Y-%m-%d %T')",
            FilterTypeEnum::DATE_IS_NOT => "{$column->getSelectAs()} != DATE_FORMAT(?, '%Y-%m-%d %T')",
            default => throw new \Exception('Invalid match mode for date filter'),
        };

        $method = $column->isHavingRequired() ? 'havingRaw' : 'whereRaw';
        $query->$method("$expression = ?", [...$column->getBindings(), $filterData->value]);

        return $query;
    }
}
