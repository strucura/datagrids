<?php

namespace Strucura\DataGrid\Tests\Fakes;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Strucura\DataGrid\Abstracts\AbstractDataGrid;
use Strucura\DataGrid\Columns\IntegerColumn;
use Strucura\DataGrid\Columns\StringColumn;
use Strucura\DataGrid\Contracts\DataGridContract;
use Strucura\DataGrid\FloatingFilters\DateRangeFloatingFilter;

class UserDataGrid extends AbstractDataGrid implements DataGridContract
{
    public function getColumns(): Collection
    {
        return collect([
            IntegerColumn::make('users.id', 'ID'),
            StringColumn::make('users.name', 'Name'),
            StringColumn::make('users.email', 'Email'),
        ]);
    }

    public function getQuery(): Builder
    {
        return DB::table('users');
    }

    public function getFloatingFilters(): Collection
    {
        return collect([
            DateRangeFloatingFilter::make('users.created_at', 'Created At'),
        ]);
    }
}
