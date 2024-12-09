<?php

namespace Strucura\DataGrid\Tests\Data;

use Illuminate\Support\Collection;
use Strucura\DataGrid\Data\DataGridData;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Data\FilterSetData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\SortOperator;
use Strucura\DataGrid\Http\Requests\DataGridDataRequest;
use Strucura\DataGrid\Tests\TestCase;

class GridDataTest extends TestCase
{
    public function test_creates_grid_data_from_grid_data_request()
    {
        // Create a DataGridDataRequest with necessary inputs
        $request = DataGridDataRequest::create('/grid-data', 'GET', [
            'filter_sets' => [
                [
                    'filters' => [
                        ['alias' => 'name', 'value' => 'Doe', 'filter_operator' => 'equals'],
                        ['alias' => 'age', 'value' => 40, 'filter_operator' => 'lt'],
                    ],
                    'filter_set_operator' => 'and',
                ],
            ],
            'sorts' => [
                ['alias' => 'name', 'sort_operator' => 'asc'],
                ['alias' => 'age', 'sort_operator' => 'desc'],
            ],
        ]);

        // Create DataGridData from the request
        $gridData = DataGridData::fromRequest($request);

        // Assert filters
        $this->assertInstanceOf(Collection::class, $gridData->filterSets);
        $this->assertCount(1, $gridData->filterSets);
        $this->assertInstanceOf(FilterSetData::class, $gridData->filterSets[0]);

        $filterSet = $gridData->filterSets[0];

        $this->assertInstanceOf(FilterSetData::class, $filterSet);
        $this->assertInstanceOf(Collection::class, $filterSet->filters);
        $this->assertCount(2, $filterSet->filters);

        $this->assertInstanceOf(FilterData::class, $filterSet->filters[0]);
        $this->assertEquals('name', $filterSet->filters[0]->alias);
        $this->assertEquals('Doe', $filterSet->filters[0]->value);
        $this->assertEquals(FilterOperator::EQUALS, $filterSet->filters[0]->filterType);
        $this->assertEquals('age', $filterSet->filters[1]->alias);
        $this->assertEquals(40, $filterSet->filters[1]->value);
        $this->assertEquals(FilterOperator::LESS_THAN, $filterSet->filters[1]->filterType);

        // Assert sorts
        $this->assertInstanceOf(Collection::class, $gridData->sorts);
        $this->assertCount(2, $gridData->sorts);
        $this->assertInstanceOf(SortData::class, $gridData->sorts[0]);
        $this->assertEquals('name', $gridData->sorts[0]->alias);
        $this->assertEquals(SortOperator::ASC, $gridData->sorts[0]->sortType);
        $this->assertEquals('age', $gridData->sorts[1]->alias);
        $this->assertEquals(SortOperator::DESC, $gridData->sorts[1]->sortType);
    }
}
