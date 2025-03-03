<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\DateColumn;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Tests\TestCase;

class DateColumnTest extends TestCase
{
    public function test_date_column_initializes_with_correct_data_type()
    {
        $column = new DateColumn('table.column', 'alias');
        $this->assertEquals(ColumnType::Date, $column->toArray()['type']);
    }

    public function test_date_column_to_array_structure()
    {
        $column = new DateColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('alias', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['alias']);
        $this->assertEquals(ColumnType::Date, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertTrue($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_date_correctly()
    {
        $column = new DateColumn('table.column', 'alias');
        $column->setExpression('table.column');
        $this->assertEquals('table.column', $column->getExpression());
    }
}
