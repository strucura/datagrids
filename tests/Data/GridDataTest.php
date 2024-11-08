<?php

namespace Strucura\DataGrid\Tests;

use Illuminate\Support\Collection;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Data\GridData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;
use Strucura\DataGrid\Http\Requests\GridDataRequest;

class GridDataTest extends TestCase
{
    public function testCreatesGridDataFromGridDataRequest()
    {
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
        $this->assertInstanceOf(Collection::class, $gridData->filters);
        $this->assertCount(2, $gridData->filters);
        $this->assertInstanceOf(FilterData::class, $gridData->filters[0]);
        $this->assertEquals('name', $gridData->filters[0]->column);
        $this->assertEquals('John', $gridData->filters[0]->value);
        $this->assertEquals(FilterTypeEnum::EQUALS, $gridData->filters[0]->filterType);
        $this->assertEquals('age', $gridData->filters[1]->column);
        $this->assertEquals(30, $gridData->filters[1]->value);
        $this->assertEquals(FilterTypeEnum::GREATER_THAN, $gridData->filters[1]->filterType);

        // Assert sorts
        $this->assertInstanceOf(Collection::class, $gridData->sorts);
        $this->assertCount(2, $gridData->sorts);
        $this->assertInstanceOf(SortData::class, $gridData->sorts[0]);
        $this->assertEquals('name', $gridData->sorts[0]->column);
        $this->assertEquals(SortTypeEnum::ASC, $gridData->sorts[0]->sortType);
        $this->assertEquals('age', $gridData->sorts[1]->column);
        $this->assertEquals(SortTypeEnum::DESC, $gridData->sorts[1]->sortType);
    }
}
