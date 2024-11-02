<?php

// config for Strucura/DataGrid
use Spatie\StructureDiscoverer\DiscoverConditions\DiscoverCondition;
use Spatie\StructureDiscoverer\Support\Conditions\ConditionBuilder;
use Strucura\DataGrid\Contracts\GridContract;
use Strucura\DataGrid\Filters\DateFilter;
use Strucura\DataGrid\Filters\EqualityFilter;
use Strucura\DataGrid\Filters\NumericFilter;
use Strucura\DataGrid\Filters\StringFilter;
use Strucura\DataGrid\ValueTransformers\BooleanValueTransformer;
use Strucura\DataGrid\ValueTransformers\FloatValueTransformer;
use Strucura\DataGrid\ValueTransformers\IntegerValueTransformer;
use Strucura\DataGrid\ValueTransformers\NullValueTransformer;
use Strucura\DataGrid\ValueTransformers\TimezoneValueTransformer;

return [
    /**
     * Used to discover grids in the application.
     */
    'discovery' => [
        'paths' => [
            app_path(''),
        ],
        'conditions' => [
            ConditionBuilder::create()
                ->classes()
                ->implementing(GridContract::class),
        ],
    ],

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
