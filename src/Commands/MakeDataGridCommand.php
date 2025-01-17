<?php

namespace Strucura\DataGrid\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeDataGridCommand extends GeneratorCommand
{
    protected $signature = 'make:data-grid {name}';

    protected $type = 'data-grid';

    public function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\DataGrids';
    }

    public function getStub()
    {
        return __DIR__.'/../../stubs/make-data-grid.stub';
    }

    public function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace('DATA_GRID_NAME', $this->argument('name'), $stub);
    }
}
