<?php

namespace Strucura\DataGrid\Data;

use Illuminate\Support\Collection;
use Strucura\DataGrid\Enums\FilterSetOperator;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;
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
                    $filter['column'],
                    $filter['value'],
                    FilterTypeEnum::tryFrom($filter['filter_type'])
                ));
            }

            $filterSets->push(new FilterSetData(
                $filters,
                FilterSetOperator::tryFrom($filterSetsRequestItem['filter_operator'])
            ));
        }

        $requestSorts = $request->input('sorts', []);
        $sorts = collect();
        foreach ($requestSorts as $sort) {
            $sorts->push(new SortData(
                $sort['column'],
                SortTypeEnum::tryFrom($sort['sort_type']))
            );
        }

        return new self($filterSets, $sorts);
    }
}
