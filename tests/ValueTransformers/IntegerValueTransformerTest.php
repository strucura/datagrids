<?php

namespace Strucura\DataGrid\Tests\ValueTransformers;

use Strucura\DataGrid\Tests\TestCase;
use Strucura\DataGrid\ValueTransformers\IntegerValueTransformer;

class IntegerValueTransformerTest extends TestCase
{
    public function testConvertsNumericStringsWithoutDecimalPointToIntegers()
    {
        $transformer = new IntegerValueTransformer;
        $next = fn ($value) => $value;

        $result1 = $transformer->handle('123', $next);
        $result2 = $transformer->handle('0', $next);

        $this->assertSame(123, $result1);
        $this->assertSame(0, $result2);
    }

    public function testLeavesNumericStringsWithDecimalPointUnchanged()
    {
        $transformer = new IntegerValueTransformer;
        $next = fn ($value) => $value;

        $result = $transformer->handle('123.45', $next);

        $this->assertSame('123.45', $result);
    }

    public function testLeavesNonNumericValuesUnchanged()
    {
        $transformer = new IntegerValueTransformer;
        $next = fn ($value) => $value;

        $result1 = $transformer->handle('abc', $next);
        $result2 = $transformer->handle(true, $next);
        $result3 = $transformer->handle(null, $next);

        $this->assertSame('abc', $result1);
        $this->assertTrue($result2);
        $this->assertNull($result3);
    }
}
