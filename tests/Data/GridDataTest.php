<?php

// tests/Data/GridDataTest.php

use Illuminate\Support\Collection;
use Strucura\DataGrid\Data\GridData;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;
use Strucura\DataGrid\Requests\GridDataRequest;

it('creates GridData from GridDataRequest', function () {
    // Create a GridDataRequest with necessary inputs
    $request = GridDataRequest::create('/grid-data', 'GET', [
        'filters' => [
            ['column' => 'name', 'value' => 'John', 'filter_type' => 'equals'],
            ['column' => 'age', 'value' => 30, 'filter_type' => 'gt'],
        ],
        'sorts' => [
            ['column' => 'name', 'sort_type' => 'asc'],
            ['column' => 'age', 'sort_type' => 'desc'],
        ],
    ]);

    // Create GridData from the request
    $gridData = GridData::fromRequest($request);

    // Assert filters
    expect($gridData->filters)->toBeInstanceOf(Collection::class)
        ->and($gridData->filters)->toHaveCount(2)
        ->and($gridData->filters[0])->toBeInstanceOf(FilterData::class)
        ->and($gridData->filters[0]->column)->toBe('name')
        ->and($gridData->filters[0]->value)->toBe('John')
        ->and($gridData->filters[0]->filterType)->toBe(FilterTypeEnum::EQUALS)
        ->and($gridData->filters[1]->column)->toBe('age')
        ->and($gridData->filters[1]->value)->toBe(30)
        ->and($gridData->filters[1]->filterType)->toBe(FilterTypeEnum::GREATER_THAN)
        ->and($gridData->sorts)->toBeInstanceOf(Collection::class)
        ->and($gridData->sorts)->toHaveCount(2)
        ->and($gridData->sorts[0])->toBeInstanceOf(SortData::class)
        ->and($gridData->sorts[0]->column)->toBe('name')
        ->and($gridData->sorts[0]->sortType)->toBe(SortTypeEnum::ASC)
        ->and($gridData->sorts[1]->column)->toBe('age')
        ->and($gridData->sorts[1]->sortType)->toBe(SortTypeEnum::DESC);

    // Assert sorts
});
