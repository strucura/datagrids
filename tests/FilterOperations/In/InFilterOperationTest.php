<?php

namespace Strucura\DataGrid\Tests\FilterOperations\In;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\In\InFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class InFilterOperationTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', ['value1', 'value2'], FilterOperator::IN);

        $filter = new InFilterOperation;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle_not_null_values()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', ['value1', 'value2'], FilterOperator::IN);

        $column->shouldReceive('getExpression')->andReturn('key');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('key IN (?,?)', ['value1', 'value2'])
            ->andReturnSelf();

        $query->shouldNotReceive('orWhereNull')
            ->with('key')
            ->andReturnSelf();

        $filter = new InFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }

    public function test_handle_with_null_values()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', ['value1', null], FilterOperator::IN);

        $column->shouldReceive('getExpression')->andReturn('key');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('key IN (?,?)', ['value1', null])
            ->andReturnSelf();

        $query->shouldReceive('orWhereNull')
            ->once()
            ->with('key')
            ->andReturnSelf();

        $filter = new InFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
