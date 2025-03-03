<?php

namespace Strucura\DataGrid\Tests\Normalizers;

use Strucura\DataGrid\Normalizers\IntegerNormalizer;
use Strucura\DataGrid\Tests\TestCase;

class IntegerNormalizerTest extends TestCase
{
    public function test_converts_numeric_strings_without_decimal_point_to_integers()
    {
        $normalizer = new IntegerNormalizer;
        $next = fn ($value) => $value;

        $result1 = $normalizer->handle('123', $next);
        $result2 = $normalizer->handle('0', $next);

        $this->assertSame(123, $result1);
        $this->assertSame(0, $result2);
    }

    public function test_leaves_numeric_strings_with_decimal_point_unchanged()
    {
        $normalizer = new IntegerNormalizer;
        $next = fn ($value) => $value;

        $result = $normalizer->handle('123.45', $next);

        $this->assertSame('123.45', $result);
    }

    public function test_leaves_non_numeric_values_unchanged()
    {
        $normalizer = new IntegerNormalizer;
        $next = fn ($value) => $value;

        $result1 = $normalizer->handle('abc', $next);
        $result2 = $normalizer->handle(true, $next);
        $result3 = $normalizer->handle(null, $next);

        $this->assertSame('abc', $result1);
        $this->assertTrue($result2);
        $this->assertNull($result3);
    }
}
