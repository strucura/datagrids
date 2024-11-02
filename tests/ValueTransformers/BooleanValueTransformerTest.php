<?php

use Strucura\DataGrid\ValueTransformers\BooleanValueTransformer;

it('converts "true" and "on" strings to true', function () {
    $transformer = new BooleanValueTransformer;
    $next = fn ($value) => $value;

    $result1 = $transformer->handle('true', $next);
    $result2 = $transformer->handle('on', $next);

    expect($result1)->toBeTrue()
        ->and($result2)->toBeTrue();
});

it('converts "false" and "off" strings to false', function () {
    $transformer = new BooleanValueTransformer;
    $next = fn ($value) => $value;

    $result1 = $transformer->handle('false', $next);
    $result2 = $transformer->handle('off', $next);

    expect($result1)->toBeFalse()
        ->and($result2)->toBeFalse();
});

it('leaves other values unchanged', function () {
    $transformer = new BooleanValueTransformer;
    $next = fn ($value) => $value;

    $result1 = $transformer->handle('abc', $next);
    $result2 = $transformer->handle(123, $next);
    $result3 = $transformer->handle(null, $next);

    expect($result1)->toBe('abc')
        ->and($result2)->toBe(123)
        ->and($result3)->toBeNull();
});
