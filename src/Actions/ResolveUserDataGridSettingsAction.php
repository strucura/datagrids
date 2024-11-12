<?php

namespace Strucura\DataGrid\Actions;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Contracts\DataGridSettingResolverContract;
use Strucura\DataGrid\Models\DataGridSetting;

class ResolveUserDataGridSettingsAction
{
    public function handle(User $user, string $gridKey): Collection
    {
        // Get all the resolvers from the config file
        $resolvers = config('datagrids.setting_resolvers', []);

        // Initialize the settings collection
        $settings = collect();

        // Loop through all the resolvers and resolve the settings
        foreach ($resolvers as $resolver) {
            /** @var DataGridSettingResolverContract $resolver */
            $resolver = app($resolver);
            /** @var Collection $settings */
            $resolverSettings = $resolver->resolve($user, $gridKey);

            // Concatenate the settings
            $settings = $settings->concat($resolverSettings);
        }

        // Return the unique settings
        return $settings->unique(function (DataGridSetting $setting) {
            return $setting->id;
        })->sortBy(function (DataGridSetting $setting) {
            return $setting->name;
        }, SORT_NATURAL);
    }
}
