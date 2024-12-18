<?php

namespace Strucura\DataGrid\Tests\FilterOperations\Date;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\Dates\DateOnOrBeforeFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class DateOnOrBeforeFilterOperationTest extends TestCase
{
    public function test_it_can_handle_date_on_or_before_filter_type()
    {
        $filter = new DateOnOrBeforeFilterOperation;
        $column = $this->mock(AbstractColumn::class);
        $filterData = new FilterData('test_column', filterOperator: FilterOperator::DATE_ON_OR_BEFORE, value: '2023-10-10');

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_it_handles_query_correctly_for_dates()
    {
        $filter = new DateOnOrBeforeFilterOperation;
        $column = $this->mock(AbstractColumn::class);
        $column->shouldReceive('getExpression')->andReturn('test_column');
        $column->shouldReceive('getBindings')->andReturn([]);
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $filterData = new FilterData('test_column', filterOperator: FilterOperator::DATE_ON_OR_BEFORE, value: '2023-10-10');
        $query = $this->mock(Builder::class);
        $query->shouldReceive('whereRaw')->with("test_column <= DATE_FORMAT(?, '%Y-%m-%d')", ['2023-10-10'])->andReturnSelf();

        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
