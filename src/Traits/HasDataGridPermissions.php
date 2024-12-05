<?php

namespace Strucura\DataGrid\Traits;

use Illuminate\Support\Str;

trait HasDataGridPermissions
{
    public function getPermissionName(): string
    {
        return Str::of(static::class)
            ->classBasename()
            ->snake('_')
            ->toString();
    }
}
