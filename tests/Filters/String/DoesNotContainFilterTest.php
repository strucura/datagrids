<?php

namespace Strucura\DataGrid\Tests\Filters\String;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\String\DoesNotContainFilter;
use Strucura\DataGrid\Tests\TestCase;

class DoesNotContainFilterTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 'value', FilterTypeEnum::DOES_NOT_CONTAIN);

        $filter = new DoesNotContainFilter;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('name', 'value', FilterTypeEnum::DOES_NOT_CONTAIN);

        $column->shouldReceive('getSelectAs')->andReturn('name');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('name NOT LIKE ?', ['%value%'])
            ->andReturnSelf();

        $filter = new DoesNotContainFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
