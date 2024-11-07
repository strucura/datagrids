<?php

namespace Strucura\DataGrid\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Strucura\DataGrid\DataGridServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Strucura\\DataGrid\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->artisan('migrate:refresh', ['--database' => 'testing']);

    }

    protected function getPackageProviders($app): array
    {
        return [
            DataGridServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
