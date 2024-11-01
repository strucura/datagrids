<?php

// tests/Actions/GenerateGridQueryActionTest.php

use Mockery;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Actions\GenerateGridQueryAction;
use Strucura\DataGrid\Contracts\GridContract;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Data\SortData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Enums\SortTypeEnum;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Illuminate\Database\Query\Builder;

it('applies filters correctly', function () {
    $gridContract = Mockery::mock(GridContract::class);
    $query = Mockery::mock(Builder::class);
    $column = Mockery::mock(AbstractColumn::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::CONTAINS);
    $filters = new Collection([$filterData]);
    $sorts = new Collection();

    $gridContract->shouldReceive('getQuery')->andReturn($query);
    $gridContract->shouldReceive('getColumns')->andReturn(new Collection([$column]));

    $column->shouldReceive('getAlias')->andReturn('column');
    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('selectRaw')->once()->with('column as `column`', []);
    $query->shouldReceive('whereRaw')->once()->with('column LIKE ?', ['%value%']);

    $action = new GenerateGridQueryAction();
    $action->handle($gridContract, $filters, $sorts);
});

it('applies sorts correctly', function () {
    $gridContract = Mockery::mock(GridContract::class);
    $query = Mockery::mock(Builder::class);
    $column = Mockery::mock(AbstractColumn::class);
    $sortData = new SortData('column', SortTypeEnum::ASC);
    $filters = new Collection();
    $sorts = new Collection([$sortData]);

    $gridContract->shouldReceive('getQuery')->andReturn($query);
    $gridContract->shouldReceive('getColumns')->andReturn(new Collection([$column]));

    $column->shouldReceive('getAlias')->andReturn('column');
    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('getBindings')->andReturn([]);
    $query->shouldReceive('selectRaw')->once()->with('column as `column`', []);

    $query->shouldReceive('orderBy')->once()->with('column', 'asc');

    $action = new GenerateGridQueryAction();
    $action->handle($gridContract, $filters, $sorts);
});

it('selects columns correctly', function () {
    $gridContract = Mockery::mock(GridContract::class);
    $query = Mockery::mock(Builder::class);
    $column = Mockery::mock(AbstractColumn::class);
    $filters = new Collection();
    $sorts = new Collection();

    $gridContract->shouldReceive('getQuery')->andReturn($query);
    $gridContract->shouldReceive('getColumns')->andReturn(new Collection([$column]));

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('getAlias')->andReturn('alias');
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('selectRaw')->once()->with('column as `alias`', []);

    $action = new GenerateGridQueryAction();
    $action->handle($gridContract, $filters, $sorts);
});
