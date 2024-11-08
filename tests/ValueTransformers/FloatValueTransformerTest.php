<?php

namespace Strucura\DataGrid\Tests\ValueTransformers;

use Strucura\DataGrid\Tests\TestCase;
use Strucura\DataGrid\ValueTransformers\FloatValueTransformer;

class FloatValueTransformerTest extends TestCase
{
    public function testConvertsNumericStringsWithDecimalPointToFloats()
    {
        $transformer = new FloatValueTransformer;
        $next = fn ($value) => $value;

        $result1 = $transformer->handle('123.45', $next);
        $result2 = $transformer->handle('0.0', $next);

        $this->assertSame(123.45, $result1);
        $this->assertSame(0.0, $result2);
    }

    public function testLeavesNumericStringsWithoutDecimalPointUnchanged()
    {
        $transformer = new FloatValueTransformer;
        $next = fn ($value) => $value;

        $result = $transformer->handle('123', $next);

        $this->assertSame('123', $result);
    }

    public function testLeavesNonNumericValuesUnchanged()
    {
        $transformer = new FloatValueTransformer;
        $next = fn ($value) => $value;

        $result1 = $transformer->handle('abc', $next);
        $result2 = $transformer->handle(true, $next);
        $result3 = $transformer->handle(null, $next);

        $this->assertSame('abc', $result1);
        $this->assertTrue($result2);
        $this->assertNull($result3);
    }
}
