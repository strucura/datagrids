<?php

namespace Strucura\DataGrid\Tests\Filters\String;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\String\EndsWithFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class EndsWithFilterTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 'value', FilterOperator::STRING_ENDS_WITH);

        $filter = new EndsWithFilterOperation;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('name', 'value', FilterOperator::STRING_ENDS_WITH);

        $column->shouldReceive('getExpression')->andReturn('name');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('name LIKE ?', ['%value'])
            ->andReturnSelf();

        $filter = new EndsWithFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
