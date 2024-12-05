<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\DateColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class DateColumnTest extends TestCase
{
    public function test_date_column_initializes_with_correct_data_type()
    {
        $column = new DateColumn('table.column', 'alias');
        $this->assertEquals(ColumnTypeEnum::Date, $column->toArray()['type']);
    }

    public function test_date_column_to_array_structure()
    {
        $column = new DateColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['name']);
        $this->assertEquals(ColumnTypeEnum::Date, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertTrue($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_date_correctly()
    {
        $column = new DateColumn('table.column', 'alias');
        $column->setSelectAs('table.column');
        $this->assertEquals("DATE_FORMAT(table.column, '%Y-%m-%d')", $column->getSelectAs());
    }
}
