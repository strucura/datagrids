<?php

// config for Strucura/DataGrid
use Spatie\StructureDiscoverer\Support\Conditions\ConditionBuilder;
use Strucura\DataGrid\Abstracts\AbstractDataGrid;
use Strucura\DataGrid\Filters\Dates\DateAfterFilter;
use Strucura\DataGrid\Filters\Dates\DateBeforeFilter;
use Strucura\DataGrid\Filters\Dates\DateIsFilter;
use Strucura\DataGrid\Filters\Dates\DateIsNotFilter;
use Strucura\DataGrid\Filters\Dates\DateOnOrAfterFilter;
use Strucura\DataGrid\Filters\Dates\DateOnOrBeforeFilter;
use Strucura\DataGrid\Filters\Equals\DoesNotEqualFilter;
use Strucura\DataGrid\Filters\Equals\EqualsFilter;
use Strucura\DataGrid\Filters\In\InFilter;
use Strucura\DataGrid\Filters\In\NotInFilter;
use Strucura\DataGrid\Filters\Numeric\GreaterThanFilter;
use Strucura\DataGrid\Filters\Numeric\GreaterThanOrEqualToFilter;
use Strucura\DataGrid\Filters\Numeric\LessThanFilter;
use Strucura\DataGrid\Filters\Numeric\LessThanOrEqualToFilter;
use Strucura\DataGrid\Filters\String\ContainsFilter;
use Strucura\DataGrid\Filters\String\DoesNotContainFilter;
use Strucura\DataGrid\Filters\String\EndsWithFilter;
use Strucura\DataGrid\Filters\String\StartsWithFilter;
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
    'filters' => [
        // Equality
        EqualsFilter::class,
        DoesNotEqualFilter::class,

        // Dates
        DateAfterFilter::class,
        DateBeforeFilter::class,
        DateIsFilter::class,
        DateIsNotFilter::class,
        DateOnOrBeforeFilter::class,
        DateOnOrAfterFilter::class,

        // In
        InFilter::class,
        NotInFilter::class,

        // Numeric
        GreaterThanFilter::class,
        GreaterThanOrEqualToFilter::class,
        LessThanFilter::class,
        LessThanOrEqualToFilter::class,

        // String
        ContainsFilter::class,
        DoesNotContainFilter::class,
        EndsWithFilter::class,
        StartsWithFilter::class,
    ],
];
