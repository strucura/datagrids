<?php

// config for Strucura/Grids
use Strucura\Grids\Filters\DateFilter;
use Strucura\Grids\Filters\EqualityFilter;
use Strucura\Grids\Filters\NumericFilter;
use Strucura\Grids\Filters\StringFilter;
use Strucura\Grids\ValueTransformers\BooleanValueTransformer;
use Strucura\Grids\ValueTransformers\FloatValueTransformer;
use Strucura\Grids\ValueTransformers\IntegerValueTransformer;
use Strucura\Grids\ValueTransformers\NullValueTransformer;
use Strucura\Grids\ValueTransformers\TimezoneValueTransformer;

return [
    /**
     * Used to perform data manipulations on the value of a filter before applying it to the query.
     */
    'value_transformers' => [
        BooleanValueTransformer::class,
        TimezoneValueTransformer::class,
        FloatValueTransformer::class,
        IntegerValueTransformer::class,
        NullValueTransformer::class,
    ],

    /**
     * A list of filters that can be applied to a data source.
     */
    'filters' => [
        StringFilter::class,
        NumericFilter::class,
        DateFilter::class,
        EqualityFilter::class,
    ],
];
