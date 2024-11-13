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
        $this->assertEquals(ColumnTypeEnum::Float, $column->toArray()['data_type']);
    }

    public function test_float_column_to_array_structure()
    {
        $column = new FloatColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('column', $array);
        $this->assertArrayHasKey('header', $array);
        $this->assertArrayHasKey('data_type', $array);
        $this->assertArrayHasKey('sortable', $array);
        $this->assertArrayHasKey('filterable', $array);
        $this->assertArrayHasKey('hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['column']);
        $this->assertEquals('alias', $array['header']);
        $this->assertEquals(ColumnTypeEnum::Float, $array['data_type']);
        $this->assertTrue($array['sortable']);
        $this->assertTrue($array['filterable']);
        $this->assertFalse($array['hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_float_correctly()
    {
        $column = new FloatColumn('table.column', 'alias');
        $column->setSelectAs('table.column');
        $this->assertEquals('CAST(table.column AS FLOAT)', $column->getSelectAs());
    }
}
