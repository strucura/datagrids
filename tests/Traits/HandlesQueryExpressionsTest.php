<?php

namespace Strucura\DataGrid\Tests\Traits;

use Strucura\DataGrid\Tests\TestCase;
use Strucura\DataGrid\Traits\HandlesQueryExpressions;

class HandlesQueryExpressionsTest extends TestCase
{
    private function getTraitMock(array $constructorArgs = []): object
    {
        return new class(...$constructorArgs) {
            use HandlesQueryExpressions;
        };
    }

    public function test_it_can_set_and_get_select_as()
    {
        $mock = $this->getTraitMock(['test_column', 'test_alias']);
        $mock->setSelectAs('new_select_as');
        $this->assertEquals('new_select_as', $mock->getSelectAs());
    }

    public function test_it_can_add_and_get_bindings()
    {
        $mock = $this->getTraitMock(['test_column', 'test_alias']);
        $mock->addBinding('test_binding');
        $this->assertContains('test_binding', $mock->getBindings());
    }

    public function test_it_can_get_alias()
    {
        $mock = $this->getTraitMock(['test_column', 'test_alias']);
        $this->assertEquals('test_alias', $mock->getAlias());
    }

    public function test_it_can_check_if_having_is_required()
    {
        $mock = $this->getTraitMock(['COUNT(test_column)', 'test_alias']);
        $this->assertTrue($mock->isHavingRequired());

        $mock = $this->getTraitMock(['test_column', 'test_alias']);
        $this->assertFalse($mock->isHavingRequired());
    }

    public function test_it_can_be_created_with_make_method()
    {
        $mock = $this->getTraitMock(['', '']);
        $instance = $mock::make('test_column', 'test_alias', ['test_binding']);

        $this->assertEquals('test_column', $instance->getSelectAs());
        $this->assertEquals('test_alias', $instance->getAlias());
        $this->assertContains('test_binding', $instance->getBindings());
    }
}
