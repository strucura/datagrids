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
        $this->assertEquals(ColumnTypeEnum::Boolean, $column->toArray()['data_type']);
    }

    public function test_boolean_column_to_array_structure()
    {
        $column = new BooleanColumn('table.column', 'alias');
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
        $this->assertEquals(ColumnTypeEnum::Boolean, $array['data_type']);
        $this->assertTrue($array['sortable']);
        $this->assertTrue($array['filterable']);
        $this->assertFalse($array['hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_get_select_as_returns_correct_value()
    {
        $column = new BooleanColumn('table.column', 'alias');
        $this->assertEquals('table.column', $column->getSelectAs());
    }
}
