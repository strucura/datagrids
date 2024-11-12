<?php

namespace Strucura\DataGrid\Tests\Normalizers;

use Strucura\DataGrid\Normalizers\NullNormalizer;
use Strucura\DataGrid\Tests\TestCase;

class NullNormalizerTest extends TestCase
{
    public function test_converts_null_string_to_null()
    {
        $normalizer = new NullNormalizer;
        $next = fn ($value) => $value;

        $result = $normalizer->handle('null', $next);

        $this->assertNull($result);
    }

    public function test_converts_empty_string_to_null()
    {
        $normalizer = new NullNormalizer;
        $next = fn ($value) => $value;

        $result = $normalizer->handle('', $next);

        $this->assertNull($result);
    }

    public function test_leaves_other_values_unchanged()
    {
        $normalizer = new NullNormalizer;
        $next = fn ($value) => $value;

        $result1 = $normalizer->handle('some string', $next);
        $result2 = $normalizer->handle(123, $next);
        $result3 = $normalizer->handle(true, $next);

        $this->assertSame('some string', $result1);
        $this->assertSame(123, $result2);
        $this->assertTrue($result3);
    }
}
