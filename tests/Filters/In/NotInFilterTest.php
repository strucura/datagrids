<?php

namespace Strucura\DataGrid\Tests\Filters\In;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\In\NotInFilter;
use Strucura\DataGrid\Tests\TestCase;

class NotInFilterTest extends TestCase
{
    public function testCanHandle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', ['value1', 'value2'], FilterTypeEnum::NOT_IN);

        $filter = new NotInFilter;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function testHandle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('key', ['value1', 'value2'], FilterTypeEnum::NOT_IN);

        $column->shouldReceive('getSelectAs')->andReturn('key');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('key NOT IN (?,?)', ['value1', 'value2'])
            ->andReturnSelf();

        $filter = new NotInFilter;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
