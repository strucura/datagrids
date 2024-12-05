<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\FloatColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class FloatColumnTest extends TestCase
{
    public function test_float_column_initializes_with_correct_data_type()
    {
        $column = new FloatColumn('table.column', 'alias');
        $this->assertEquals(ColumnTypeEnum::Float, $column->toArray()['type']);
    }

    public function test_float_column_to_array_structure()
    {
        $column = new FloatColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['name']);
        $this->assertEquals(ColumnTypeEnum::Float, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertTrue($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_float_correctly()
    {
        $column = new FloatColumn('table.column', 'alias');
        $column->setSelectAs('table.column');
        $this->assertEquals('CAST(table.column AS FLOAT)', $column->getSelectAs());
    }
}
