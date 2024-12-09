<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\StringColumn;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Tests\TestCase;

class StringColumnTest extends TestCase
{
    public function test_string_column_initializes_with_correct_data_type()
    {
        $column = new StringColumn('table.column', 'alias');
        $this->assertEquals(ColumnType::String, $column->toArray()['type']);
    }

    public function test_string_column_to_array_structure()
    {
        $column = new StringColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('alias', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['alias']);
        $this->assertEquals(ColumnType::String, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertTrue($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }
}
