<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\DateTimeColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class DateTimeColumnTest extends TestCase
{
    public function test_date_time_column_initializes_with_correct_data_type()
    {
        $column = new DateTimeColumn('table.column', 'alias');
        $this->assertEquals(ColumnTypeEnum::DateTime, $column->toArray()['data_type']);
    }

    public function test_date_time_column_to_array_structure()
    {
        $column = new DateTimeColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('field', $array);
        $this->assertArrayHasKey('header', $array);
        $this->assertArrayHasKey('data_type', $array);
        $this->assertArrayHasKey('sortable', $array);
        $this->assertArrayHasKey('filterable', $array);
        $this->assertArrayHasKey('hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['field']);
        $this->assertEquals('alias', $array['header']);
        $this->assertEquals(ColumnTypeEnum::DateTime, $array['data_type']);
        $this->assertTrue($array['sortable']);
        $this->assertTrue($array['filterable']);
        $this->assertFalse($array['hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_date_time_correctly()
    {
        $column = new DateTimeColumn('table.column', 'alias');
        $column->setSelectAs('table.column');
        $this->assertEquals("DATE_FORMAT(table.column, '%Y-%m-%d %T')", $column->getSelectAs());
    }
}
