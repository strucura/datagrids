<?php

namespace Strucura\DataGrid\Filters\Dates;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractFilter;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;

class DateAfterFilter extends AbstractFilter
{
    public function canHandle(AbstractColumn $column, FilterData $filterData): bool
    {
        return $filterData->filterType === FilterOperator::DATE_AFTER;
    }

    /**
     * @throws \Exception
     */
    public function handle(Builder $query, AbstractColumn $column, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder
    {
        if ($column->getColumnType() === ColumnType::Date) {
            $expression = "{$column->getSelectAs()} > DATE_FORMAT(?, '%Y-%m-%d')";
        } elseif ($column->getColumnType() === ColumnType::DateTime) {
            $expression = "{$column->getSelectAs()} > DATE_FORMAT(?, '%Y-%m-%d %T')";
        } else {
            throw new \Exception('Column type not supported.');
        }

        $method = $this->getQueryMethod($column, $filterOperator);
        $query->$method($expression, [...$column->getBindings(), $filterData->value]);

        return $query;
    }
}
