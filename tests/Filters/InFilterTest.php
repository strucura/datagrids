<?php

// tests/Filters/InFilterTest.php

use Illuminate\Database\Query\Builder;
use Strucura\DataGrid\Abstracts\AbstractColumn;
use Strucura\DataGrid\Columns\NumberColumn;
use Strucura\DataGrid\Data\FilterData;
use Strucura\DataGrid\Enums\FilterTypeEnum;
use Strucura\DataGrid\Filters\InFilter;

it('can handle IN filter type', function () {
    $filter = new InFilter;
    $column = Mockery::mock(AbstractColumn::class);
    $filterData = new FilterData('column', ['value1', 'value2'], FilterTypeEnum::IN);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('can handle NOT_IN filter type', function () {
    $filter = new InFilter;
    $column = Mockery::mock(AbstractColumn::class);
    $filterData = new FilterData('column', ['value1', 'value2'], FilterTypeEnum::NOT_IN);

    expect($filter->canHandle($column, $filterData))->toBeTrue();
});

it('applies the correct SQL expression for NOT_IN filter type', function () {
    $filter = new InFilter;
    $column = Mockery::mock(NumberColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', ['value2'], FilterTypeEnum::NOT_IN);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);
    $query->shouldReceive('whereRaw')
        ->once()
        ->with('column NOT IN (?)', ['value2'])
        ->andReturnSelf();

    $filter->handle($query, $column, $filterData);

    $query->shouldHaveReceived('whereRaw')->with('column NOT IN (?)', ['value2']);
});

it('applies the correct SQL expression for IN filter type', function () {
    $filter = new InFilter;
    $column = Mockery::mock(NumberColumn::class);
    $query = Mockery::mock(Builder::class);
    $filterData = new FilterData('column', ['value2'], FilterTypeEnum::IN);

    $column->shouldReceive('getSelectAs')->andReturn('column');
    $column->shouldReceive('isHavingRequired')->andReturn(false);
    $column->shouldReceive('getBindings')->andReturn([]);
    $query->shouldReceive('whereRaw')
        ->once()
        ->with('column IN (?)', ['value2'])
        ->andReturnSelf();

    $filter->handle($query, $column, $filterData);

    $query->shouldHaveReceived('whereRaw')->with('column IN (?)', ['value2']);
});
