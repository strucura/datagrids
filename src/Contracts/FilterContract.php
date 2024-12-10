<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterSetOperator;

/**
 * Used to define the means for applying a specific filter operator to the query.
 */
interface FilterContract
{
    /**
     * Determines if the filter can handle the given filter data
     *
     * @param QueryableContract $queryableContract
     * @param FilterData $filterData
     * @return bool
     */
    public function canHandle(QueryableContract $queryableContract, FilterData $filterData): bool;

    /**
     * Handles the application of the filter to the query
     *
     * @param Builder $query
     * @param QueryableContract $queryableContract
     * @param FilterData $filterData
     * @param FilterSetOperator $filterOperator
     * @return Builder
     */
    public function handle(Builder $query, QueryableContract $queryableContract, FilterData $filterData, FilterSetOperator $filterOperator = FilterSetOperator::AND): Builder;
}
