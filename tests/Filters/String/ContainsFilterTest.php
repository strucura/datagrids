<?php

namespace Strucura\DataGrid\Tests\Filters\String;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\FilterOperations\String\ContainsFilterOperation;
use Strucura\DataGrid\Tests\TestCase;

class ContainsFilterTest extends TestCase
{
    public function test_can_handle()
    {
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('column', 'value', FilterOperator::STRING_CONTAINS);

        $filter = new ContainsFilterOperation;

        $this->assertTrue($filter->canHandle($column, $filterData));
    }

    public function test_handle()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $filterData = new FilterData('name', 'value', FilterOperator::STRING_CONTAINS);

        $column->shouldReceive('getExpression')->andReturn('name');
        $column->shouldReceive('isHavingRequired')->andReturn(false);
        $column->shouldReceive('getBindings')->andReturn([]);

        $query->shouldReceive('whereRaw')
            ->once()
            ->with('name LIKE ?', ['%value%'])
            ->andReturnSelf();

        $filter = new ContainsFilterOperation;
        $result = $filter->handle($query, $column, $filterData);

        $this->assertSame($query, $result);
    }
}
