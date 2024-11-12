<?php

namespace Strucura\DataGrid\Tests\Actions;

use Illuminate\Foundation\Auth\User;
use Strucura\DataGrid\Actions\PersistDataGridSettingAction;
use Strucura\DataGrid\Data\DataGridSettingData;
use Strucura\DataGrid\Models\DataGridSetting;
use Strucura\DataGrid\Tests\TestCase;

class PersistDataGridSettingActionTest extends TestCase
{
    public function test_it_creates_a_new_data_grid_setting_if_it_does_not_exist()
    {
        $user = User::query()->forceCreate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $data = new DataGridSettingData(
            ownerId: $user->id,
            dataGridKey: 'test_grid',
            name: 'test_setting',
            value: ['key' => 'value']
        );

        $action = PersistDataGridSettingAction::make();
        $dataGridSetting = $action->handle($data);

        $this->assertDatabaseHas(DataGridSetting::class, [
            'owner_id' => 1,
            'data_grid_key' => 'test_grid',
            'name' => 'test_setting',
            'value' => json_encode(['key' => 'value']),
        ]);

        $this->assertEquals($data->value, $dataGridSetting->value);
    }

    public function test_it_updates_an_existing_data_grid_setting_if_it_already_exists()
    {
        $user = User::query()->forceCreate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $existingSetting = DataGridSetting::query()->create([
            'owner_id' => $user->id,
            'data_grid_key' => 'test_grid',
            'name' => 'test_setting',
            'value' => json_encode(['old_key' => 'old_value']),
        ]);

        $data = new DataGridSettingData(
            ownerId: 1,
            dataGridKey: 'test_grid',
            name: 'test_setting',
            value: ['new_key' => 'new_value']
        );

        $action = PersistDataGridSettingAction::make();
        $dataGridSetting = $action->handle($data);

        $this->assertDatabaseHas(DataGridSetting::class, [
            'id' => $existingSetting->id,
            'owner_id' => 1,
            'data_grid_key' => 'test_grid',
            'name' => 'test_setting',
            'value' => json_encode(['new_key' => 'new_value']),
        ]);

        $this->assertEquals($data->value, $dataGridSetting->value);
    }
}
