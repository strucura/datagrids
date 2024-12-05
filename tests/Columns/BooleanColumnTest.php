<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\BooleanColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class BooleanColumnTest extends TestCase
{
    public function test_boolean_column_initializes_with_correct_data_type()
    {
        $column = new BooleanColumn('table.column', 'alias');
        $this->assertEquals(ColumnTypeEnum::Boolean, $column->toArray()['type']);
    }

    public function test_boolean_column_to_array_structure()
    {
        $column = new BooleanColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['name']);
        $this->assertEquals(ColumnTypeEnum::Boolean, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertTrue($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_get_select_as_returns_correct_value()
    {
        $column = new BooleanColumn('table.column', 'alias');
        $this->assertEquals('table.column', $column->getSelectAs());
    }
}
