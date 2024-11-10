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
        $this->assertEquals(ColumnTypeEnum::Date, $column->toArray()['data_type']);
    }

    public function test_date_column_to_array_structure()
    {
        $column = new DateColumn('table.column', 'alias');
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
        $this->assertEquals(ColumnTypeEnum::Date, $array['data_type']);
        $this->assertTrue($array['sortable']);
        $this->assertTrue($array['filterable']);
        $this->assertFalse($array['hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_date_correctly()
    {
        $column = new DateColumn('table.column', 'alias');
        $column->setSelectAs('table.column');
        $this->assertEquals("DATE_FORMAT(table.column, '%Y-%m-%d')", $column->getSelectAs());
    }
}
