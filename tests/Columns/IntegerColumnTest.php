<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\IntegerColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class IntegerColumnTest extends TestCase
{
    public function test_integer_column_initializes_with_correct_data_type()
    {
        $column = new IntegerColumn('table.column', 'alias');
        $this->assertEquals(ColumnTypeEnum::Integer, $column->toArray()['data_type']);
    }

    public function test_integer_column_to_array_structure()
    {
        $column = new IntegerColumn('table.column', 'alias');
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
        $this->assertEquals(ColumnTypeEnum::Integer, $array['data_type']);
        $this->assertTrue($array['sortable']);
        $this->assertTrue($array['filterable']);
        $this->assertFalse($array['hidden']);
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
