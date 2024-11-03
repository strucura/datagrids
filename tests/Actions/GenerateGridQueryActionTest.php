<?php

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Abstracts\AbstractGrid;
use Strucura\DataGrid\Actions\GenerateGridQueryAction;
use Strucura\DataGrid\Contracts\GridContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Data\GridData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;

function mockColumn($alias, $selectAs, $bindings = [], $havingRequired = false)
{
    $column = Mockery::mock(AbstractColumn::class);
    $column->shouldReceive('getAlias')->andReturn($alias);
    $column->shouldReceive('getSelectAs')->andReturn($selectAs);
    $column->shouldReceive('getBindings')->andReturn($bindings);
    $column->shouldReceive('isHavingRequired')->andReturn($havingRequired);

    return $column;
}

it('applies filters correctly', function () {
    $gridContract = Mockery::mock(AbstractGrid::class);
    $query = Mockery::mock(Builder::class);
    $column = mockColumn('column', 'column');
    $filterData = new FilterData('column', 'value', FilterTypeEnum::CONTAINS);
    $filters = new Collection([$filterData]);
    $sorts = new Collection;

    $gridContract->shouldReceive('getQuery')->andReturn($query);
    $gridContract->shouldReceive('getColumns')->andReturn(new Collection([$column]));

    $query->shouldReceive('selectRaw')->once()->with('column as `column`', []);
    $query->shouldReceive('whereRaw')->once()->with('column LIKE ?', ['%value%']);

    $action = new GenerateGridQueryAction;
    $action->handle($gridContract->getQuery(), $gridContract->getColumns(), new GridData($filters, $sorts));
});

it('applies sorts correctly', function () {
    $gridContract = Mockery::mock(GridContract::class);
    $query = Mockery::mock(Builder::class);
    $column = mockColumn('column', 'column');
    $sortData = new SortData('column', SortTypeEnum::ASC);
    $filters = new Collection;
    $sorts = new Collection([$sortData]);

    $gridContract->shouldReceive('getQuery')->andReturn($query);
    $gridContract->shouldReceive('getColumns')->andReturn(new Collection([$column]));

    $query->shouldReceive('selectRaw')->once()->with('column as `column`', []);
    $query->shouldReceive('orderBy')->once()->with('column', 'asc');

    $action = new GenerateGridQueryAction;
    $action->handle($gridContract->getQuery(), $gridContract->getColumns(), new GridData($filters, $sorts));
});

it('selects columns correctly', function () {
    $gridContract = Mockery::mock(GridContract::class);
    $query = Mockery::mock(Builder::class);
    $column = mockColumn('alias', 'column');
    $filters = new Collection;
    $sorts = new Collection;

    $gridContract->shouldReceive('getQuery')->andReturn($query);
    $gridContract->shouldReceive('getColumns')->andReturn(new Collection([$column]));

    $query->shouldReceive('selectRaw')->once()->with('column as `alias`', []);

    $action = new GenerateGridQueryAction;
    $action->handle($gridContract->getQuery(), $gridContract->getColumns(), new GridData($filters, $sorts));
});
