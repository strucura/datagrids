<?php

namespace Strucura\DataGrid\Tests\Traits;

use Strucura\DataGrid\Tests\TestCase;
use Strucura\DataGrid\Traits\HandlesMetaData;

class HandlesMetaDataTest extends TestCase
{
    private function getTraitMock(): object
    {
        return new class {
            use HandlesMetaData;
        };
    }

    public function test_it_can_add_and_retrieve_meta_data()
    {
        $mock = $this->getTraitMock();
        $mock->withMeta('key', 'value');
        $this->assertEquals('value', $mock->getMeta('key'));
    }

    public function test_it_can_chain_with_meta_calls()
    {
        $mock = $this->getTraitMock();
        $mock->withMeta('key1', 'value1')->withMeta('key2', 'value2');
        $this->assertEquals('value1', $mock->getMeta('key1'));
        $this->assertEquals('value2', $mock->getMeta('key2'));
    }

    public function test_it_returns_null_for_non_existent_meta_key()
    {
        $mock = $this->getTraitMock();
        $this->assertNull($mock->getMeta('non_existent_key'));
    }
}
