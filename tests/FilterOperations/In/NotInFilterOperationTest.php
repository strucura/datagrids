<?php

namespace Strucura\DataGrid\Tests\FilterOperations\In;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\In\NotInFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class NotInFilterOperationTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', ['value1', 'value2'], FilterOperator::NOT_IN);

        $filter = new NotInFilterOperation;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle_without_nulls()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('key', ['value1', 'value2'], FilterOperator::NOT_IN);

        $column->shouldReceive('getExpression')->andReturn('key');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldNotReceive('orWhereNotNull')
            ->with('key')
            ->andReturnSelf();

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('key NOT IN (?,?)', ['value1', 'value2'])
            ->andReturnSelf();

        $filter = new NotInFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }

    public function test_handle_with_nulls()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('key', ['value1', 'value2'], FilterOperator::NOT_IN);

        $column->shouldReceive('getExpression')->andReturn('key');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('key NOT IN (?,?)', ['value1', 'value2'])
            ->andReturnSelf();

        $query->shouldReceive('orWhereNotNull')
            ->with('key')
            ->andReturnSelf();

        $filter = new NotInFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
