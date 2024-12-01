<?php

namespace Strucura\DataGrid\Tests\Filters\Date;

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Filters\Dates\DateOnOrBeforeFilter;
use Strucura\DataGrid\Tests\TestCase;

class DateOnOrBeforeFilterTest extends TestCase
{
    public function test_it_can_handle_date_on_or_before_filter_type()
    {
        $filter = new DateOnOrBeforeFilter;
        $column = $this->mock(AbstractColumn::class);
        $filterData = new FilterData('test_column', filterType: FilterOperator::DATE_ON_OR_BEFORE, value: '2023-10-10');

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    /** @test */
    public function it_handles_query_correctly()
    {
        $filter = new DateOnOrBeforeFilter;
        $column = $this->mock(AbstractColumn::class);
        $column->shouldReceive('getSelectAs')->andReturn('test_column');
        $column->shouldReceive('getBindings')->andReturn([]);
        $column->shouldReceive('isHavingRequired')->andReturn(false);

        $filterData = new FilterData('test_column', filterType: FilterOperator::DATE_ON_OR_BEFORE, value: '2023-10-10');
        $query = $this->mock(Builder::class);
        $query->shouldReceive('whereRaw')->with("test_column <= DATE_FORMAT(?, '%Y-%m-%d %T')", ['2023-10-10'])->andReturnSelf();

        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
