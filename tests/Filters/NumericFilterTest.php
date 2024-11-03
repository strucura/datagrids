<?php

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Columns\NumberColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\NumericFilter;

it('can handle LESS_THAN filter type', function () {
    $filter = new NumericFilter;
    $column = Mockery::mock(NumberColumn::class);
    $filterData = new FilterData('column', 10, FilterTypeEnum::LESS_THAN);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle LESS_THAN_OR_EQUAL_TO filter type', function () {
    $filter = new NumericFilter;
    $column = Mockery::mock(NumberColumn::class);
    $filterData = new FilterData('column', 10, FilterTypeEnum::LESS_THAN_OR_EQUAL_TO);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle GREATER_THAN filter type', function () {
    $filter = new NumericFilter;
    $column = Mockery::mock(NumberColumn::class);
    $filterData = new FilterData('column', 10, FilterTypeEnum::GREATER_THAN);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle GREATER_THAN_OR_EQUAL_TO filter type', function () {
    $filter = new NumericFilter;
    $column = Mockery::mock(NumberColumn::class);
    $filterData = new FilterData('column', 10, FilterTypeEnum::GREATER_THAN_OR_EQUAL_TO);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('applies the correct SQL expression for LESS_THAN filter type', function () {
    $filter = new NumericFilter;
    $column = Mockery::mock(NumberColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 10, FilterTypeEnum::LESS_THAN);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column < ?', [10]);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for LESS_THAN_OR_EQUAL_TO filter type', function () {
    $filter = new NumericFilter;
    $column = Mockery::mock(NumberColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 10, FilterTypeEnum::LESS_THAN_OR_EQUAL_TO);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column <= ?', [10]);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for GREATER_THAN filter type', function () {
    $filter = new NumericFilter;
    $column = Mockery::mock(NumberColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 10, FilterTypeEnum::GREATER_THAN);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column > ?', [10]);

    $filter->handle($query, $column, $filterData);
});

it('applies the correct SQL expression for GREATER_THAN_OR_EQUAL_TO filter type', function () {
    $filter = new NumericFilter;
    $column = Mockery::mock(NumberColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', 10, FilterTypeEnum::GREATER_THAN_OR_EQUAL_TO);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $query->shouldReceive('whereRaw')->once()->with('column >= ?', [10]);

    $filter->handle($query, $column, $filterData);
});
