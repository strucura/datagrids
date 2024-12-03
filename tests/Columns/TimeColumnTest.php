<?php

namespace Strucura\DataGrid\Tests\Columns;

use Strucura\DataGrid\Columns\TimeColumn;
use Strucura\DataGrid\Enums\ColumnTypeEnum;
use Strucura\DataGrid\Tests\TestCase;

class TimeColumnTest extends TestCase
{
    public function test_time_column_initializes_with_correct_data_type()
    {
        $column = new TimeColumn('table.column', 'alias');
        $this->assertEquals(ColumnTypeEnum::Time, $column->toArray()['column_type']);
    }

    public function test_time_column_to_array_structure()
    {
        $column = new TimeColumn('table.column', 'alias');
        $array = $column->toArray();

        $this->assertArrayHasKey('field', $array);
        $this->assertArrayHasKey('header', $array);
        $this->assertArrayHasKey('column_type', $array);
        $this->assertArrayHasKey('sortable', $array);
        $this->assertArrayHasKey('filterable', $array);
        $this->assertArrayHasKey('hidden', $array);
        $this->assertArrayHasKey('meta', $array);

        $this->assertEquals('alias', $array['field']);
        $this->assertEquals('alias', $array['header']);
        $this->assertEquals(ColumnTypeEnum::Time, $array['column_type']);
        $this->assertTrue($array['sortable']);
        $this->assertTrue($array['filterable']);
        $this->assertFalse($array['hidden']);
        $this->assertIsArray($array['meta']);
    }
}
