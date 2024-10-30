<?php

namespace Strucura\Grids\Commands;

use Illuminate\Console\Command;

class GridsCommand extends Command
{
    public $signature = 'grids';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
