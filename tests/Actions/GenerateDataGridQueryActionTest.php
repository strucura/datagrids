<?php

namespace Strucura\DataGrid\Tests\Actions;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractDataGrid;
use Strucura\DataGrid\Actions\GenerateGridQueryAction;
use Strucura\DataGrid\Contracts\GridContract;
use Strucura\DataGrid\Data\DataGridData;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class GenerateDataGridQueryActionTest extends TestCase
{
    private function mockColumn($alias, $selectAs, $bindings = [], $havingRequired = false)
    {
        $column = $this->createMock(AbstractColumn::class);
        $column->method('getAlias')->willReturn($alias);
        $column->method('getSelectAs')->willReturn($selectAs);
        $column->method('getBindings')->willReturn($bindings);
        $column->method('isHavingRequired')->willReturn($havingRequired);

        return $column;
    }

    public function test_applies_filters_correctly()
    {
        $gridContract = $this->createMock(AbstractDataGrid::class);
        $query = $this->createMock(Builder::class);
        $column = $this->mockColumn('column', 'column');
        $filterData = new FilterData('column', 'value', FilterTypeEnum::CONTAINS);
        $filters = new Collection([$filterData]);
        $sorts = new Collection;

        $gridContract->method('getQuery')->willReturn($query);
        $gridContract->method('getColumns')->willReturn(new Collection([$column]));

        $query->expects($this->once())->method('selectRaw')->with('column as `column`', []);
        $query->expects($this->once())->method('whereRaw')->with('column LIKE ?', ['%value%']);

        $action = new GenerateGridQueryAction;
        $action->handle($gridContract->getQuery(), $gridContract->getColumns(), new DataGridData($filters, $sorts));
    }

    public function test_applies_sorts_correctly()
    {
        $gridContract = $this->createMock(GridContract::class);
        $query = $this->createMock(Builder::class);
        $column = $this->mockColumn('column', 'column');
        $sortData = new SortData('column', SortTypeEnum::ASC);
        $filters = new Collection;
        $sorts = new Collection([$sortData]);

        $gridContract->method('getQuery')->willReturn($query);
        $gridContract->method('getColumns')->willReturn(new Collection([$column]));

        $query->expects($this->once())->method('selectRaw')->with('column as `column`', []);
        $query->expects($this->once())->method('orderBy')->with('column', 'asc');

        $action = new GenerateGridQueryAction;
        $action->handle($gridContract->getQuery(), $gridContract->getColumns(), new DataGridData($filters, $sorts));
    }

    public function test_selects_columns_correctly()
    {
        $gridContract = $this->createMock(GridContract::class);
        $query = $this->createMock(Builder::class);
        $column = $this->mockColumn('alias', 'column');
        $filters = new Collection;
        $sorts = new Collection;

        $gridContract->method('getQuery')->willReturn($query);
        $gridContract->method('getColumns')->willReturn(new Collection([$column]));

        $query->expects($this->once())->method('selectRaw')->with('column as `alias`', []);

        $action = new GenerateGridQueryAction;
        $action->handle($gridContract->getQuery(), $gridContract->getColumns(), new DataGridData($filters, $sorts));
    }
}
