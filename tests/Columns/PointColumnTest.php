<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\PointColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class PointColumnTest extends TestCase
{
    public function test_point_column_initializes_with_correct_data_type()
    {
        $column = new PointColumn('table.column', 'alias');
        $this->assertEquals(ColumnTypeEnum::Point, $column->toArray()['data_type']);
    }

    public function test_point_column_to_array_structure()
    {
        $column = new PointColumn('table.column', 'alias');
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
        $this->assertEquals(ColumnTypeEnum::Point, $array['data_type']);
        $this->assertTrue($array['sortable']);
        $this->assertFalse($array['filterable']);
        $this->assertFalse($array['hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_point_correctly()
    {
        $column = new PointColumn('table.column', 'alias');
        $column->setSelectAs('table.column');
        $this->assertEquals("CONCAT(ST_X(table.column), ',', ST_Y(table.column))", $column->getSelectAs());
    }
}
