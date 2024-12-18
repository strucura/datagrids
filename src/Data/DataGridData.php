<?php

namespace Strucura\DataGrid\Data;

use Illuminate\Support\Collection;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\FilterSetOperator;
use Strucura\DataGrid\Enums\SortOperator;
use Strucura\DataGrid\Http\Requests\DataGridDataRequest;

class DataGridData
{
    /**
     * @param  Collection<FilterSetData>  $filterSets
     * @param  Collection<SortData>  $sorts
     */
    public function __construct(public Collection $filterSets, public Collection $sorts) {}

    public static function fromRequest(DataGridDataRequest $request): self
    {
        $requestFilterSets = $request->input('filter_sets', []);

        $filterSets = collect();
        foreach ($requestFilterSets as $filterSetsRequestItem) {
            $filters = collect();
            foreach ($filterSetsRequestItem['filters'] as $filter) {
                $filters->push(new FilterData(
                    $filter['alias'],
                    $filter['value'],
                    FilterOperator::tryFrom($filter['filter_operator'])
                ));
            }

            $filterSets->push(new FilterSetData(
                $filters,
                FilterSetOperator::tryFrom($filterSetsRequestItem['filter_set_operator'])
            ));
        }

        $requestSorts = $request->input('sorts', []);
        $sorts = collect();
        foreach ($requestSorts as $sort) {
            $sorts->push(new SortData(
                $sort['alias'],
                SortOperator::tryFrom($sort['sort_operator']))
            );
        }

        return new self($filterSets, $sorts);
    }
}
