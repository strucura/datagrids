<?php

namespace Strucura\DataGrid\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use Strucura\DataGrid\Models\DataGridSetting;

interface DataGridSettingResolverContract
{
    /**
     * Resolve the user's data grid settings for the given grid key.
     *
     * @return Collection<DataGridSetting>
     */
    public function resolve(User $user, string $gridKey): Collection;
}
