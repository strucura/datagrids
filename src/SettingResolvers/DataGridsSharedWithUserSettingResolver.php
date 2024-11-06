<?php

namespace Strucura\DataGrid\SettingResolvers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Contracts\DataGridSettingResolverContract;

class DataGridsSharedWithUserSettingResolver implements DataGridSettingResolverContract
{
    public function resolve(Authenticatable $user, string $gridKey): Collection
    {
        // TODO: Implement resolve() method.
    }
}
