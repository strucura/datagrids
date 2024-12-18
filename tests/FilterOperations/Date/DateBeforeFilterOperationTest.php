<?php

namespace Strucura\DataGrid\Tests\FilterOperations\Date;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\Dates\DateBeforeFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class DateBeforeFilterOperationTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', '2024-10-12', FilterOperator::DATE_BEFORE);

        $filter = new DateBeforeFilterOperation;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle_dates()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', '2023-01-01', FilterOperator::DATE_BEFORE);

        $column->shouldReceive('getExpression')->andReturn('created_at');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);
        $query->shouldReceive('whereRaw')
            ->once()
            ->with('created_at < DATE_FORMAT(?, \'%Y-%m-%d\')', ['2023-01-01'])
            ->andReturnSelf();

        $filter = new DateBeforeFilterOperation;
        $filter->handle($query, $column, $filterData);
    }
}