<?php

namespace Strucura\DataGrid\Tests\FilterOperations\Equals;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\Equality\DoesNotEqualFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class DoesNotEqualFilterOperationTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 'value', FilterOperator::NOT_EQUALS);

        $filter = new DoesNotEqualFilterOperation;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', '2023-01-01 00:00:00', FilterOperator::NOT_EQUALS);

        $column->shouldReceive('getExpression')->andReturn('created_at');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('created_at != ?', ['2023-01-01 00:00:00'])
            ->andReturnSelf();

        $filter = new DoesNotEqualFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
