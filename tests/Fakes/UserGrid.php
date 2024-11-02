<?php

namespace Strucura\DataGrid\Tests\Fakes;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Strucura\DataGrid\Abstracts\AbstractGrid;
use Strucura\DataGrid\Columns\NumberColumn;
use Strucura\DataGrid\Columns\StringColumn;

class UserGrid extends AbstractGrid
{
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
