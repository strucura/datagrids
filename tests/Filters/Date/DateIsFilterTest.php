<?php

namespace Strucura\DataGrid\Tests\Filters\Date;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Filters\Dates\DateIsFilter;
use Strucura\DataGrid\Tests\TestCase;

class DateIsFilterTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', '2024-10-12', FilterOperator::DATE_IS);

        $filter = new DateIsFilter;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle_date_times()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', '2023-01-01 00:00:00', FilterOperator::DATE_IS);

        $column->shouldReceive('getSelectAs')->andReturn('created_at');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);
        $column->shouldReceive('getColumnType')->andReturn(ColumnTypeEnum::DateTime);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('created_at = DATE_FORMAT(?, \'%Y-%m-%d %T\')', ['2023-01-01 00:00:00'])
            ->andReturnSelf();

        $filter = new DateIsFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }

    public function test_handle_dates()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', '2023-01-01', FilterOperator::DATE_IS);

        $column->shouldReceive('getSelectAs')->andReturn('created_at');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);
        $column->shouldReceive('getColumnType')->andReturn(ColumnTypeEnum::Date);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('created_at = DATE_FORMAT(?, \'%Y-%m-%d\')', ['2023-01-01'])
            ->andReturnSelf();

        $filter = new DateIsFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
