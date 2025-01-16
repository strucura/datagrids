<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\NumberColumn;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Tests\TestCase;

class NumberColumnTest extends TestCase
{
    public function test_number_column_initializes_with_correct_data_type()
    {
        $column = new NumberColumn('table.column', 'alias');
        $this->assertEquals(ColumnType::Number, $column->toArray()['type']);
    }

    public function test_number_column_to_array_structure()
    {
        $column = new NumberColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('alias', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['alias']);
        $this->assertEquals(ColumnType::Number, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertTrue($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_float_method_sets_expression_correctly()
    {
        $column = new NumberColumn('table.column', 'alias');
        $column->float();
        $this->assertEquals('CAST(table.column AS FLOAT)', $column->getExpression());
    }

    public function test_signed_method_sets_expression_correctly()
    {
        $column = new NumberColumn('table.column', 'alias');
        $column->signed();
        $this->assertEquals('CAST(table.column AS SIGNED)', $column->getExpression());
    }

    public function test_unsigned_method_sets_expression_correctly()
    {
        $column = new NumberColumn('table.column', 'alias');
        $column->unsigned();
        $this->assertEquals('CAST(table.column AS UNSIGNED)', $column->getExpression());
    }
}
