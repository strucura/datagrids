<?php

namespace Strucura\DataGrid\Data;

use Illuminate\Support\Collection;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;
use Strucura\DataGrid\Http\Requests\GridDataRequest;

class GridData
{
    public function __construct(public Collection $filters, public Collection $sorts) {}

    public static function fromRequest(GridDataRequest $request): self
    {
        $requestFilters = $request->input('filters', []);

        $filters = collect();
        foreach ($requestFilters as $filter) {
            $filters->push(new FilterData(
                $filter['column'],
                $filter['value'],
                FilterTypeEnum::tryFrom($filter['filter_type']))
            );
        }

        $requestSorts = $request->input('sorts', []);
        $sorts = collect();
        foreach ($requestSorts as $sort) {
            $sorts->push(new SortData(
                $sort['column'],
                SortTypeEnum::tryFrom($sort['sort_type']))
            );
        }

        return new self($filters, $sorts);
    }
}
