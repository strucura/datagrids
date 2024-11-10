<?php

namespace Strucura\DataGrid\Tests\Filters\String;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\String\StartsWithFilter;
use Strucura\DataGrid\Tests\TestCase;

class StartsWithFilterTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 'value', FilterTypeEnum::STARTS_WITH);

        $filter = new StartsWithFilter;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('name', 'value', FilterTypeEnum::STARTS_WITH);

        $column->shouldReceive('getSelectAs')->andReturn('name');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('name LIKE ?', ['value%'])
            ->andReturnSelf();

        $filter = new StartsWithFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
