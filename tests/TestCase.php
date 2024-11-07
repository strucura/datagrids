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
        $migration = include __DIR__.'/../database/migrations/2024_11_04_140837_create_data_grid_settings_table.php';
        $migration = include __DIR__.'/../database/migrations/2024_11_06_133920_create_data_grid_setting_user_table.php';
        $migration->up();

    }
}
