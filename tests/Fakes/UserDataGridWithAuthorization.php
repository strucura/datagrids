<?php

namespace Strucura\DataGrid\Tests\Fakes;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Strucura\DataGrid\Abstracts\AbstractDataGrid;
use Strucura\DataGrid\Columns\NumberColumn;
use Strucura\DataGrid\Columns\StringColumn;
use Strucura\DataGrid\Contracts\DataGridContract;
use Strucura\DataGrid\Traits\HasDataGridPermissions;

class UserDataGridWithAuthorization extends AbstractDataGrid implements DataGridContract
{
    use HasDataGridPermissions;

    public function getColumns(): Collection
    {
        return collect([
            NumberColumn::make('users.id', 'ID'),
            StringColumn::make('users.name', 'Name'),
            StringColumn::make('users.email', 'Email'),
        ]);
    }

    public function getQuery(): Builder
    {
        return DB::table('users');
    }
}
