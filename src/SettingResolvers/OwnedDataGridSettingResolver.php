<?php

namespace Strucura\DataGrid\SettingResolvers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Contracts\DataGridSettingResolverContract;
use Strucura\DataGrid\Models\DataGridSetting;

class OwnedDataGridSettingResolver implements DataGridSettingResolverContract
{
    public function resolve(Authenticatable $user, string $gridKey): Collection
    {
        return DataGridSetting::query()
            ->where('owner_id', $user->getAuthIdentifier())
            ->where('grid_key', $gridKey)
            ->get();
    }
}
