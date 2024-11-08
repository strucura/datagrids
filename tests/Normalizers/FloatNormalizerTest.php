<?php

namespace Strucura\DataGrid\Tests\Normalizers;

use Strucura\DataGrid\Normalizers\FloatNormalizer;
use Strucura\DataGrid\Tests\TestCase;

class FloatNormalizerTest extends TestCase
{
    public function testConvertsNumericStringsWithDecimalPointToFloats()
    {
        $normalizer = new FloatNormalizer;
        $next = fn ($value) => $value;

        $result1 = $normalizer->handle('123.45', $next);
        $result2 = $normalizer->handle('0.0', $next);

        $this->assertSame(123.45, $result1);
        $this->assertSame(0.0, $result2);
    }

    public function testLeavesNumericStringsWithoutDecimalPointUnchanged()
    {
        $normalizer = new FloatNormalizer;
        $next = fn ($value) => $value;

        $result = $normalizer->handle('123', $next);

        $this->assertSame('123', $result);
    }

    public function testLeavesNonNumericValuesUnchanged()
    {
        $normalizer = new FloatNormalizer;
        $next = fn ($value) => $value;

        $result1 = $normalizer->handle('abc', $next);
        $result2 = $normalizer->handle(true, $next);
        $result3 = $normalizer->handle(null, $next);

        $this->assertSame('abc', $result1);
        $this->assertTrue($result2);
        $this->assertNull($result3);
    }
}
