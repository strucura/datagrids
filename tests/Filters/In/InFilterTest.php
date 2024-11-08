<?php

namespace Strucura\DataGrid\Tests\Filters\In;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\In\InFilter;
use Strucura\DataGrid\Tests\TestCase;

class InFilterTest extends TestCase
{
    public function testCanHandle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', ['value1', 'value2'], FilterTypeEnum::IN);

        $filter = new InFilter();

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function testHandle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('created_at', ['2023-01-01 00:00:00', '2023-01-02 00:00:00'], FilterTypeEnum::IN);

        $column->shouldReceive('getSelectAs')->andReturn('created_at');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('created_at IN (?,?)', ['2023-01-01 00:00:00', '2023-01-02 00:00:00'])
            ->andReturnSelf();

        $filter = new InFilter();
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
