<?php

namespace Strucura\DataGrid\Tests\ValueTransformers;

use Strucura\DataGrid\Tests\TestCase;
use Strucura\DataGrid\ValueTransformers\NullValueTransformer;

class NullValueTransformerTest extends TestCase
{
    public function testConvertsNullStringToNull()
    {
        $transformer = new NullValueTransformer;
        $next = fn ($value) => $value;

        $result = $transformer->handle('null', $next);

        $this->assertNull($result);
    }

    public function testConvertsEmptyStringToNull()
    {
        $transformer = new NullValueTransformer;
        $next = fn ($value) => $value;

        $result = $transformer->handle('', $next);

        $this->assertNull($result);
    }

    public function testLeavesOtherValuesUnchanged()
    {
        $transformer = new NullValueTransformer;
        $next = fn ($value) => $value;

        $result1 = $transformer->handle('some string', $next);
        $result2 = $transformer->handle(123, $next);
        $result3 = $transformer->handle(true, $next);

        $this->assertSame('some string', $result1);
        $this->assertSame(123, $result2);
        $this->assertTrue($result3);
    }
}
