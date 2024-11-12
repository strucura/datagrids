<?php

namespace Strucura\DataGrid\SettingResolvers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Contracts\DataGridSettingResolverContract;
use Strucura\DataGrid\Models\DataGridSetting;

class OwnedDataGridSettingResolver implements DataGridSettingResolverContract
{
    public function resolve(User $user, string $gridKey): Collection
    {
        return DataGridSetting::query()
            ->where('owner_id', $user->getAuthIdentifier())
            ->where('data_grid_key', $gridKey)
            ->get();
    }
}
