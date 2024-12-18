<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\DateTimeColumn;
use Strucura\DataGrid\Enums\ColumnType;
use Strucura\DataGrid\Tests\TestCase;

class DateTimeColumnTest extends TestCase
{
    public function test_date_time_column_initializes_with_correct_data_type()
    {
        $column = new DateTimeColumn('table.column', 'alias');
        $this->assertEquals(ColumnType::DateTime, $column->toArray()['type']);
    }

    public function test_date_time_column_to_array_structure()
    {
        $column = new DateTimeColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('alias', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('is_sortable', $array);
        $this->assertArrayHasKey('is_filterable', $array);
        $this->assertArrayHasKey('is_hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['alias']);
        $this->assertEquals(ColumnType::DateTime, $array['type']);
        $this->assertTrue($array['is_sortable']);
        $this->assertTrue($array['is_filterable']);
        $this->assertFalse($array['is_hidden']);
        $this->assertIsArray($array['meta']);
    }

    public function test_set_select_as_formats_date_time_correctly()
    {
        $column = new DateTimeColumn('table.column', 'alias');
        $column->setExpression('table.column');
        $this->assertEquals("DATE_FORMAT(table.column, '%Y-%m-%d %T')", $column->getExpression());
    }
}
