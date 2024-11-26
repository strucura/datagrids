<?php

namespace Strucura\DataGrid\Tests\Actions;

use Illuminate\Database\Query\Builder;
use Mockery;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Actions\GenerateDataGridQueryAction;
use Strucura\DataGrid\Data\DataGridData;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Data\FilterSetData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\FilterSetOperator;
use Strucura\DataGrid\Enums\FilterOperator;
use Strucura\DataGrid\Enums\SortOperator;
use Strucura\DataGrid\Tests\TestCase;

class GenerateDataGridQueryActionTest extends TestCase
{
    public function test_it_applies_filters_and_sorts_to_query()
    {
        $query = Mockery::mock(Builder::class);
        $column = Mockery::mock(AbstractColumn::class);
        $column->shouldReceive('getSelectAs')->andReturn('test_column');
        $column->shouldReceive('getAlias')->andReturn('test_column');
        $column->shouldReceive('getBindings')->andReturn([]);
        $column->shouldReceive('isHavingRequired')->andReturn(false);

        $filterData = new FilterData('test_column', 'test_value', FilterOperator::EQUALS);
        $filterSetData = new FilterSetData(collect([$filterData]), FilterSetOperator::AND);
        $sortData = new SortData('test_column', SortOperator::ASC);

        $gridData = new DataGridData(collect([$filterSetData]), collect([$sortData]));

        $query->shouldReceive('where')->with(Mockery::on(function ($closure) use ($query) {
            $closure($query);

            return true;
        }))->andReturnSelf();
        $query->shouldReceive('whereRaw')->with('test_column = ?', ['test_value'])->andReturnSelf();
        $query->shouldReceive('orderBy')->with('test_column', 'asc')->andReturnSelf();
        $query->shouldReceive('selectRaw')->with('test_column as `test_column`', [])->andReturnSelf();

        $action = GenerateDataGridQueryAction::make();
        $result = $action->handle($query, collect([$column]), $gridData);

        $this->assertSame($query, $result);
    }
}
