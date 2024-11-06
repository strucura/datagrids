<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Models\DataGridSetting;

interface DataGridSettingResolverContract
{
    /**
     * Resolve the user's data grid settings for the given grid key.
     *
     * @param Authenticatable $user
     * @param string $gridKey
     * @return Collection<DataGridSetting>
     */
    public function resolve(Authenticatable $user, string $gridKey): Collection;
}
