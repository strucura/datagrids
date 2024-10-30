<?php

namespace Strucura\Grids\Abstracts;

use Strucura\Grids\Contracts\DataSourceContract;
use Strucura\Grids\Contracts\FilterContract;
use Strucura\Grids\Data\FilterData;

abstract class AbstractFilter implements FilterContract
{
    public function matchFilterToColumn(DataSourceContract $dataSource, FilterData $filterData): AbstractColumn
    {
        return $dataSource->getColumns()->first(function (AbstractColumn $column) use ($filterData) {
            return $column->getAlias() === $filterData->column;
        });
    }
}
