<?php

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Columns\StringColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\StringFilter;

it('can handle STARTS_WITH filter type', function () {
    $filter = new StringFilter;
    $column = Mockery::mock(StringColumn::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::STARTS_WITH);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle ENDS_WITH filter type', function () {
    $filter = new StringFilter;
    $column = Mockery::mock(StringColumn::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::ENDS_WITH);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle CONTAINS filter type', function () {
    $filter = new StringFilter;
    $column = Mockery::mock(StringColumn::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::CONTAINS);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle NOT_CONTAINS filter type', function () {
    $filter = new StringFilter;
    $column = Mockery::mock(StringColumn::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::NOT_CONTAINS);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('applies the correct SQL expression for STARTS_WITH filter type', function () {
    $filter = new StringFilter;
    $column = Mockery::mock(StringColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::STARTS_WITH);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column LIKE ?', ['value%']);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for ENDS_WITH filter type', function () {
    $filter = new StringFilter;
    $column = Mockery::mock(StringColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::ENDS_WITH);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column LIKE ?', ['%value']);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for CONTAINS filter type', function () {
    $filter = new StringFilter;
    $column = Mockery::mock(StringColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::CONTAINS);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column LIKE ?', ['%value%']);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for NOT_CONTAINS filter type', function () {
    $filter = new StringFilter;
    $column = Mockery::mock(StringColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::NOT_CONTAINS);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column NOT LIKE ?', ['%value%']);

    $filter->handle($query, $column, $filterData);
});
