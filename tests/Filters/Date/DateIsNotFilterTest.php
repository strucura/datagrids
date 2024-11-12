<?php

namespace Strucura\DataGrid\Tests\Filters\Date;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\Dates\DateIsNotFilter;
use Strucura\DataGrid\Tests\TestCase;

class DateIsNotFilterTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', '2024-10-12', FilterTypeEnum::DATE_IS_NOT);

        $filter = new DateIsNotFilter;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', '2023-01-01 00:00:00', FilterTypeEnum::DATE_IS_NOT);

        $column->shouldReceive('getSelectAs')->andReturn('created_at');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('created_at < DATE_FORMAT(?, \'%Y-%m-%d %T\')', ['2023-01-01 00:00:00'])
            ->andReturnSelf();

        $filter = new DateIsNotFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
