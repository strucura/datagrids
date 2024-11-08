<?php

namespace Strucura\DataGrid\Tests\Filters\Numeric;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\Numeric\LessThanOrEqualToFilter;
use Strucura\DataGrid\Tests\TestCase;

class LessThanOrEqualToFilterTest extends TestCase
{
    public function testCanHandle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 10, FilterTypeEnum::LESS_THAN_OR_EQUAL_TO);

        $filter = new LessThanOrEqualToFilter;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function testHandle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('quantity', 10, FilterTypeEnum::LESS_THAN_OR_EQUAL_TO);

        $column->shouldReceive('getSelectAs')->andReturn('quantity');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('quantity <= ?', [10])
            ->andReturnSelf();

        $filter = new LessThanOrEqualToFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}