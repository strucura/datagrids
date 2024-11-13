<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\StringColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class StringColumnTest extends TestCase
{
    public function test_string_column_initializes_with_correct_data_type()
    {
        $column = new StringColumn('table.column', 'alias');
        $this->assertEquals(ColumnTypeEnum::String, $column->toArray()['data_type']);
    }

    public function test_string_column_to_array_structure()
    {
        $column = new StringColumn('table.column', 'alias');
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
        $this->assertEquals(ColumnTypeEnum::String, $array['data_type']);
        $this->assertTrue($array['sortable']);
        $this->assertTrue($array['filterable']);
        $this->assertFalse($array['hidden']);
        $this->assertIsArray($array['meta']);
    }
}
