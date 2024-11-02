<?php

namespace Strucura\DataGrid\Data;

use Illuminate\Support\Collection;
use Strucura\DataGrid\Requests\GridDataRequest;

class GridData
{
    public function __construct(public Collection $filters, public Collection $sorts) {}

    public static function fromRequest(GridDataRequest $request): self
    {
        $requestFilters = $request->input('filters', []);

        $filters = collect();
        foreach ($requestFilters as $filter) {
            $filters->push(new FilterData($filter['column'], $filter['value'], $filter['filter_type']));
        }

        $requestSorts = $request->input('sorts', []);
        $sorts = collect();
        foreach ($requestSorts as $sort) {
            $sorts->push(new SortData($sort['column'], $sort['sort_type']));
        }

        return new self($filters, $sorts);
    }
}
