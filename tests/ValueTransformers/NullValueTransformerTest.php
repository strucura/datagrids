<?php

use Strucura\DataGrid\ValueTransformers\NullValueTransformer;

it('converts "null" string to null', function () {
    $transformer = new NullValueTransformer;
    $next = fn ($value) => $value;

    $result = $transformer->handle('null', $next);

    expect($result)->toBeNull();
});

it('converts empty string to null', function () {
    $transformer = new NullValueTransformer;
    $next = fn ($value) => $value;

    $result = $transformer->handle('', $next);

    expect($result)->toBeNull();
});

it('leaves other values unchanged', function () {
    $transformer = new NullValueTransformer;
    $next = fn ($value) => $value;

    $result1 = $transformer->handle('some string', $next);
    $result2 = $transformer->handle(123, $next);
    $result3 = $transformer->handle(true, $next);

    expect($result1)->toBe('some string');
    expect($result2)->toBe(123);
    expect($result3)->toBe(true);
});
