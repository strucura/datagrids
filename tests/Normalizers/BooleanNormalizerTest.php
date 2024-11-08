<?php

namespace Strucura\DataGrid\Tests\Normalizers;

use Strucura\DataGrid\Normalizers\BooleanNormalizer;
use Strucura\DataGrid\Tests\TestCase;

class BooleanNormalizerTest extends TestCase
{
    public function testConvertsTrueAndOnStringsToTrue()
    {
        $normalizer = new BooleanNormalizer;
        $next = fn ($value) => $value;

        $result1 = $normalizer->handle('true', $next);
        $result2 = $normalizer->handle('on', $next);

        $this->assertTrue($result1);
        $this->assertTrue($result2);
    }

    public function testConvertsFalseAndOffStringsToFalse()
    {
        $normalizer = new BooleanNormalizer;
        $next = fn ($value) => $value;

        $result1 = $normalizer->handle('false', $next);
        $result2 = $normalizer->handle('off', $next);

        $this->assertFalse($result1);
        $this->assertFalse($result2);
    }

    public function testLeavesOtherValuesUnchanged()
    {
        $normalizer = new BooleanNormalizer;
        $next = fn ($value) => $value;

        $result1 = $normalizer->handle('abc', $next);
        $result2 = $normalizer->handle(123, $next);
        $result3 = $normalizer->handle(null, $next);

        $this->assertSame('abc', $result1);
        $this->assertSame(123, $result2);
        $this->assertNull($result3);
    }
}
