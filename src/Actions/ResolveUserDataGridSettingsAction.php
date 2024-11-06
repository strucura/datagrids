<?php

namespace Strucura\DataGrid\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Models\DataGridSetting;

class ResolveUserDataGridSettingsAction
{
    public function handle(Authenticatable $user, string $gridKey): Collection
    {
        // Get all the resolvers from the config file
        $resolvers = config('data_grids.resolvers');

        // Initialize the settings collection
        $settings = collect();

        // Loop through all the resolvers and resolve the settings
        foreach ($resolvers as $resolver) {
            /** @var Collection $settings */
            $resolverSettings = $resolver->resolve($user, $gridKey);

            // Concatenate the settings
            $settings->concat($resolverSettings);
        }

        // Return the unique settings
        return $settings->unique(function (DataGridSetting $setting) {
            return $setting->id;
        })->sortBy('name', SORT_NATURAL);
    }
}
