<?php

// config for Strucura/DataGrid
use Spatie\StructureDiscoverer\Support\Conditions\ConditionBuilder;
use Strucura\DataGrid\Abstracts\AbstractGrid;
use Strucura\DataGrid\Filters\DateFilter;
use Strucura\DataGrid\Filters\EqualityFilter;
use Strucura\DataGrid\Filters\NumericFilter;
use Strucura\DataGrid\Filters\StringFilter;
use Strucura\DataGrid\Models\DataGridSetting;
use Strucura\DataGrid\SettingResolvers\DataGridsSharedWithUserSettingResolver;
use Strucura\DataGrid\SettingResolvers\OwnedDataGridSettingResolver;
use Strucura\DataGrid\ValueTransformers\BooleanValueTransformer;
use Strucura\DataGrid\ValueTransformers\FloatValueTransformer;
use Strucura\DataGrid\ValueTransformers\IntegerValueTransformer;
use Strucura\DataGrid\ValueTransformers\NullValueTransformer;
use Strucura\DataGrid\ValueTransformers\TimezoneValueTransformer;
use Illuminate\Foundation\Auth\User;

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

    'setting_resolvers' => [
        OwnedDataGridSettingResolver::class,
        DataGridsSharedWithUserSettingResolver::class,
    ],

    'models' => [
        'data_grid_setting' => DataGridSetting::class,
        'user' => User::class,
    ],
];
