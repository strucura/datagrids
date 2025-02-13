<?php

namespace Strucura\DataGrid\Tests\FilterOperations\Equals;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\Equality\GreaterThanOrEqualToFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class GreaterThanOrEqualToFilterOperationTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('quantity', 10, FilterOperator::GREATER_THAN_OR_EQUAL_TO);

        $filter = new GreaterThanOrEqualToFilterOperation;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('quantity', 10, FilterOperator::GREATER_THAN_OR_EQUAL_TO);

        $column->shouldReceive('getExpression')->andReturn('quantity');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('quantity >= ?', [10])
            ->andReturnSelf();

        $filter = new GreaterThanOrEqualToFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
