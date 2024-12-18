<?php

// config for Strucura/DataGrid
use Spatie\StructureDiscoverer\Support\Conditions\ConditionBuilder;
use Strucura\DataGrid\Abstracts\AbstractDataGrid;
use Strucura\DataGrid\Filters\Dates\DateAfterFilterOperation;
use Strucura\DataGrid\Filters\Dates\DateBeforeFilterOperation;
use Strucura\DataGrid\Filters\Dates\DateIsFilterOperation;
use Strucura\DataGrid\Filters\Dates\DateIsNotFilterOperation;
use Strucura\DataGrid\Filters\Dates\DateOnOrAfterFilterOperation;
use Strucura\DataGrid\Filters\Dates\DateOnOrBeforeFilterOperation;
use Strucura\DataGrid\Filters\Equals\DoesNotEqualFilterOperation;
use Strucura\DataGrid\Filters\Equals\EqualsFilterOperation;
use Strucura\DataGrid\Filters\In\InFilterOperation;
use Strucura\DataGrid\Filters\In\NotInFilterOperation;
use Strucura\DataGrid\Filters\Numeric\GreaterThanFilterOperation;
use Strucura\DataGrid\Filters\Numeric\GreaterThanOrEqualToFilterOperation;
use Strucura\DataGrid\Filters\Numeric\LessThanFilterOperation;
use Strucura\DataGrid\Filters\Numeric\LessThanOrEqualToFilterOperation;
use Strucura\DataGrid\Filters\String\ContainsFilterOperation;
use Strucura\DataGrid\Filters\String\DoesNotContainFilterOperation;
use Strucura\DataGrid\Filters\String\EndsWithFilterOperation;
use Strucura\DataGrid\Filters\String\StartsWithFilterOperation;
use Strucura\DataGrid\Normalizers\BooleanNormalizer;
use Strucura\DataGrid\Normalizers\FloatNormalizer;
use Strucura\DataGrid\Normalizers\IntegerNormalizer;
use Strucura\DataGrid\Normalizers\NullNormalizer;
use Strucura\DataGrid\Normalizers\TimezoneNormalizer;

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
        TimezoneNormalizer::class,
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

        // Dates
        DateAfterFilterOperation::class,
        DateBeforeFilterOperation::class,
        DateIsFilterOperation::class,
        DateIsNotFilterOperation::class,
        DateOnOrBeforeFilterOperation::class,
        DateOnOrAfterFilterOperation::class,

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
