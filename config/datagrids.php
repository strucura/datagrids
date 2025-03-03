<?php

// config for Strucura/DataGrid
use Spatie\StructureDiscoverer\Support\Conditions\ConditionBuilder;
use Strucura\DataGrid\Abstracts\AbstractDataGrid;
use Strucura\DataGrid\FilterOperations\Equality\DoesNotEqualFilterOperation;
use Strucura\DataGrid\FilterOperations\Equality\EqualsFilterOperation;
use Strucura\DataGrid\FilterOperations\Equality\GreaterThanFilterOperation;
use Strucura\DataGrid\FilterOperations\Equality\GreaterThanOrEqualToFilterOperation;
use Strucura\DataGrid\FilterOperations\Equality\LessThanFilterOperation;
use Strucura\DataGrid\FilterOperations\Equality\LessThanOrEqualToFilterOperation;
use Strucura\DataGrid\FilterOperations\In\InFilterOperation;
use Strucura\DataGrid\FilterOperations\In\NotInFilterOperation;
use Strucura\DataGrid\FilterOperations\String\ContainsFilterOperation;
use Strucura\DataGrid\FilterOperations\String\DoesNotContainFilterOperation;
use Strucura\DataGrid\FilterOperations\String\EndsWithFilterOperation;
use Strucura\DataGrid\FilterOperations\String\StartsWithFilterOperation;
use Strucura\DataGrid\Normalizers\BooleanNormalizer;
use Strucura\DataGrid\Normalizers\FloatNormalizer;
use Strucura\DataGrid\Normalizers\IntegerNormalizer;
use Strucura\DataGrid\Normalizers\NullNormalizer;

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
                ->extending(AbstractDataGrid::class),
        ],
    ],

    /**
     * Used to perform data manipulations on the value of a filter before applying it to the query.
     */
    'normalizers' => [
        BooleanNormalizer::class,
        FloatNormalizer::class,
        IntegerNormalizer::class,
        NullNormalizer::class,
    ],

    /**
     * A list of filters that can be applied to a data source.
     */
    'filter_operations' => [
        // Equality
        EqualsFilterOperation::class,
        DoesNotEqualFilterOperation::class,

        // In
        InFilterOperation::class,
        NotInFilterOperation::class,

        // Numeric
        GreaterThanFilterOperation::class,
        GreaterThanOrEqualToFilterOperation::class,
        LessThanFilterOperation::class,
        LessThanOrEqualToFilterOperation::class,

        // String
        ContainsFilterOperation::class,
        DoesNotContainFilterOperation::class,
        EndsWithFilterOperation::class,
        StartsWithFilterOperation::class,
    ],
];
