<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\PointColumn;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Tests\TestCase;

class PointColumnTest extends TestCase
{
    public function test_point_column_initializes_with_correct_data_type()
    {
        $column = new PointColumn('table.column', 'alias');
        $this->assertEquals(ColumnType::Point, $column->toArray()['type']);
    }

    public function test_point_column_to_array_structure()
    {
        $column = new PointColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('alias', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['alias']);
        $this->assertEquals(ColumnType::Point, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertFalse($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_point_correctly()
    {
        $column = new PointColumn('table.column', 'alias');
        $column->setExpression('table.column');
        $this->assertEquals("CONCAT(ST_X(table.column), ',', ST_Y(table.column))", $column->getExpression());
    }
}
