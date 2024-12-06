<?php

namespace Strucura\DataGrid\Tests\Filters\In;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Filters\In\InFilter;
use Strucura\DataGrid\Tests\TestCase;

class InFilterTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', ['value1', 'value2'], FilterOperator::IN);

        $filter = new InFilter;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle_not_null_values()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', ['value1', 'value2'], FilterOperator::IN);

        $column->shouldReceive('getSelectAs')->andReturn('key');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('key IN (?,?)', ['value1', 'value2'])
            ->andReturnSelf();

        $query->shouldNotReceive('orWhereNull')
            ->with('key')
            ->andReturnSelf();

        $filter = new InFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }

    public function test_handle_with_null_values()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', ['value1', null], FilterOperator::IN);

        $column->shouldReceive('getSelectAs')->andReturn('key');
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

        $filter = new InFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
