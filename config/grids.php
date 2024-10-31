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
        // Strings
        'startsWith' => StringFilter::class,
        'contains' => StringFilter::class,
        'notContains' => StringFilter::class,
        'endsWith' => StringFilter::class,

        // Equality
        'equals' => EqualityFilter::class,
        'is' => EqualityFilter::class,
        'notEquals' => EqualityFilter::class,
        'isNot' => EqualityFilter::class,

        // Numeric
        'lt' => NumericFilter::class,
        'lte' => NumericFilter::class,
        'gt' => NumericFilter::class,
        'gte' => NumericFilter::class,

        // Dates
        'dateIs' => DateFilter::class,
        'dateIsNot' => DateFilter::class,
        'dateBefore' => DateFilter::class,
        'before' => DateFilter::class,
        'dateAfter' => DateFilter::class,
        'after' => DateFilter::class,
    ],
];
