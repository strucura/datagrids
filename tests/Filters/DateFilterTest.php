<?php

// tests/Filters/DateFilterTest.php

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Columns\DateColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\DateFilter;

it('can handle DATE_IS filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::DATE_IS);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle DATE_IS_NOT filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::DATE_IS_NOT);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle BEFORE filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::BEFORE);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle AFTER filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::AFTER);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle DOESNT_HAVE filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::DOESNT_HAVE);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it(/**
 * @throws Exception
 */ 'applies the correct SQL expression for DATE_IS filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::DATE_IS);

    $column->shouldReceive('getSelectAs')->andReturn('date_column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $filter->handle($query, $column, $filterData);

    // Add assertion to verify the query modification
    $query->shouldHaveReceived('whereRaw', ["date_column = DATE_FORMAT(?, '%Y-%m-%d %T') = ?", ['2023-10-01']]);
});

it('applies the correct SQL expression for DATE_IS_NOT filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::DATE_IS_NOT);

    $column->shouldReceive('getSelectAs')->andReturn('date_column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $filter->handle($query, $column, $filterData);

    // Add assertion to verify the query modification
    $query->shouldHaveReceived('whereRaw', ["date_column != DATE_FORMAT(?, '%Y-%m-%d %T') = ?", ['2023-10-01']]);
});

it('applies the correct SQL expression for BEFORE filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::BEFORE);

    $column->shouldReceive('getSelectAs')->andReturn('date_column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $filter->handle($query, $column, $filterData);

    // Add assertion to verify the query modification
    $query->shouldHaveReceived('whereRaw', ["date_column < DATE_FORMAT(?, '%Y-%m-%d %T') = ?", ['2023-10-01']]);
});

it('applies the correct SQL expression for AFTER filter type', function () {
    $filter = new DateFilter;
    $column = Mockery::mock(DateColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('date_column', '2023-10-01', FilterTypeEnum::AFTER);

    $column->shouldReceive('getSelectAs')->andReturn('date_column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);

    $filter->handle($query, $column, $filterData);

    // Add assertion to verify the query modification
    $query->shouldHaveReceived('whereRaw', ["date_column > DATE_FORMAT(?, '%Y-%m-%d %T') = ?", ['2023-10-01']]);
});
