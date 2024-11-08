<?php

// config for Strucura/DataGrid
use Illuminate\Foundation\Auth\User;
use Spatie\StructureDiscoverer\Support\Conditions\ConditionBuilder;
use Strucura\DataGrid\Abstracts\AbstractGrid;
use Strucura\DataGrid\Filters\Dates\DateAfterFilter;
use Strucura\DataGrid\Filters\Dates\DateBeforeFilter;
use Strucura\DataGrid\Filters\Dates\DateIsFilter;
use Strucura\DataGrid\Filters\Dates\DateIsNotFilter;
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
use Strucura\DataGrid\Models\DataGridSetting;
use Strucura\DataGrid\Normalizers\BooleanNormalizer;
use Strucura\DataGrid\Normalizers\FloatNormalizer;
use Strucura\DataGrid\Normalizers\IntegerNormalizer;
use Strucura\DataGrid\Normalizers\NullNormalizer;
use Strucura\DataGrid\Normalizers\TimezoneNormalizer;
use Strucura\DataGrid\SettingResolvers\DataGridsSharedWithUserSettingResolver;
use Strucura\DataGrid\SettingResolvers\OwnedDataGridSettingResolver;

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
                ->extending(AbstractGrid::class),
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
        // Dates
        DateAfterFilter::class,
        DateBeforeFilter::class,
        DateIsFilter::class,
        DateIsNotFilter::class,

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

    'setting_resolvers' => [
        OwnedDataGridSettingResolver::class,
        DataGridsSharedWithUserSettingResolver::class,
    ],

    'models' => [
        'data_grid_setting' => DataGridSetting::class,
        'user' => User::class,
    ],
];
