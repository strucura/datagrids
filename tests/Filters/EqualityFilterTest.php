<?php

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\EqualityFilter;

it('can handle EQUALS filter type', function () {
    $filter = new EqualityFilter;
    $column = Mockery::mock(AbstractColumn::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::EQUALS);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle NOT_EQUALS filter type', function () {
    $filter = new EqualityFilter;
    $column = Mockery::mock(AbstractColumn::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::NOT_EQUALS);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('applies the correct SQL expression for EQUALS filter type', function () {
    $filter = new EqualityFilter;
    $column = Mockery::mock(AbstractColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::EQUALS);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column = ?', ['value']);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for NOT_EQUALS filter type', function () {
    $filter = new EqualityFilter;
    $column = Mockery::mock(AbstractColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 'value', FilterTypeEnum::NOT_EQUALS);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column != ?', ['value']);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for EQUALS filter type with null value', function () {
    $filter = new EqualityFilter;
    $column = Mockery::mock(AbstractColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', null, FilterTypeEnum::EQUALS);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column IS NULL', []);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for NOT_EQUALS filter type with null value', function () {
    $filter = new EqualityFilter;
    $column = Mockery::mock(AbstractColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', null, FilterTypeEnum::NOT_EQUALS);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column IS NOT NULL', []);

    $filter->handle($query, $column, $filterData);
});
