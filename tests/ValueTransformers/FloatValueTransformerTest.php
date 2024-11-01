<?php

use Strucura\DataGrid\ValueTransformers\FloatValueTransformer;

it('converts numeric strings with a decimal point to floats', function () {
    $transformer = new FloatValueTransformer;
    $next = fn ($value) => $value;

    $result1 = $transformer->handle('123.45', $next);
    $result2 = $transformer->handle('0.0', $next);

    expect($result1)->toBe(123.45)
        ->and($result2)->toBe(0.0);
});

it('leaves numeric strings without a decimal point unchanged', function () {
    $transformer = new FloatValueTransformer;
    $next = fn ($value) => $value;

    $result = $transformer->handle('123', $next);

    expect($result)->toBe('123');
});

it('leaves non-numeric values unchanged', function () {
    $transformer = new FloatValueTransformer;
    $next = fn ($value) => $value;

    $result1 = $transformer->handle('abc', $next);
    $result2 = $transformer->handle(true, $next);
    $result3 = $transformer->handle(null, $next);

    expect($result1)->toBe('abc')
        ->and($result2)->toBe(true)
        ->and($result3)->toBeNull();
});
