<?php

namespace Strucura\DataGrid\Tests\Filters\Numeric;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\Numeric\GreaterThanFilter;
use Strucura\DataGrid\Tests\TestCase;

class GreaterThanFilterTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 10, FilterTypeEnum::GREATER_THAN);

        $filter = new GreaterThanFilter;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('quantity', 10, FilterTypeEnum::GREATER_THAN);

        $column->shouldReceive('getSelectAs')->andReturn('quantity');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('quantity > ?', [10])
            ->andReturnSelf();

        $filter = new GreaterThanFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
