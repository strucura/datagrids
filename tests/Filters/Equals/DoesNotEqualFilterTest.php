<?php

namespace Strucura\DataGrid\Tests\Filters\Equals;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\Equals\DoesNotEqualFilter;
use Strucura\DataGrid\Tests\TestCase;

class DoesNotEqualFilterTest extends TestCase
{
    public function testCanHandle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 'value', FilterTypeEnum::NOT_EQUALS);

        $filter = new DoesNotEqualFilter();

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function testHandle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', '2023-01-01 00:00:00', FilterTypeEnum::NOT_EQUALS);

        $column->shouldReceive('getSelectAs')->andReturn('created_at');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('created_at != ?', ['2023-01-01 00:00:00'])
            ->andReturnSelf();

        $filter = new DoesNotEqualFilter();
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
