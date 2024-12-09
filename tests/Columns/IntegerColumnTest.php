<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\IntegerColumn;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Tests\TestCase;

class IntegerColumnTest extends TestCase
{
    public function test_integer_column_initializes_with_correct_data_type()
    {
        $column = new IntegerColumn('table.column', 'alias');
        $this->assertEquals(ColumnType::Integer, $column->toArray()['type']);
    }

    public function test_integer_column_to_array_structure()
    {
        $column = new IntegerColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('alias', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['alias']);
        $this->assertEquals(ColumnType::Integer, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertTrue($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_signed_formats_integer_correctly()
    {
        $column = new IntegerColumn('table.column', 'alias');
        $column->signed();
        $this->assertEquals('CAST(table.column AS SIGNED)', $column->getSelectAs());
    }

    public function test_unsigned_formats_integer_correctly()
    {
        $column = new IntegerColumn('table.column', 'alias');
        $column->unsigned();
        $this->assertEquals('CAST(table.column AS UNSIGNED)', $column->getSelectAs());
    }
}
