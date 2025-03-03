<?php

namespace Strucura\DataGrid\Tests\FilterOperations\Equals;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\Equality\LessThanFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class LessThanFilterOperationTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 10, FilterOperator::LESS_THAN);

        $filter = new LessThanFilterOperation;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('quantity', 10, FilterOperator::LESS_THAN);

        $column->shouldReceive('getExpression')->andReturn('quantity');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('quantity < ?', [10])
            ->andReturnSelf();

        $filter = new LessThanFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
