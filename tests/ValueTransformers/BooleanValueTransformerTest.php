<?php

namespace Strucura\DataGrid\Tests\ValueTransformers;

use Strucura\DataGrid\Tests\TestCase;
use Strucura\DataGrid\ValueTransformers\BooleanValueTransformer;

class BooleanValueTransformerTest extends TestCase
{
    public function testConvertsTrueAndOnStringsToTrue()
    {
        $transformer = new BooleanValueTransformer;
        $next = fn ($value) => $value;

        $result1 = $transformer->handle('true', $next);
        $result2 = $transformer->handle('on', $next);

        $this->assertTrue($result1);
        $this->assertTrue($result2);
    }

    public function testConvertsFalseAndOffStringsToFalse()
    {
        $transformer = new BooleanValueTransformer;
        $next = fn ($value) => $value;

        $result1 = $transformer->handle('false', $next);
        $result2 = $transformer->handle('off', $next);

        $this->assertFalse($result1);
        $this->assertFalse($result2);
    }

    public function testLeavesOtherValuesUnchanged()
    {
        $transformer = new BooleanValueTransformer;
        $next = fn ($value) => $value;

        $result1 = $transformer->handle('abc', $next);
        $result2 = $transformer->handle(123, $next);
        $result3 = $transformer->handle(null, $next);

        $this->assertSame('abc', $result1);
        $this->assertSame(123, $result2);
        $this->assertNull($result3);
    }
}
