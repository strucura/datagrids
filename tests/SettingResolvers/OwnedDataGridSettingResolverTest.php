<?php

namespace Strucura\DataGrid\Tests\SettingResolvers;

use Illuminate\Foundation\Auth\User;
use Strucura\DataGrid\Models\DataGridSetting;
use Strucura\DataGrid\SettingResolvers\OwnedDataGridSettingResolver;
use Strucura\DataGrid\Tests\TestCase;

class OwnedDataGridSettingResolverTest extends TestCase
{
    public function test_resolve_returns_correct_settings()
    {
        $user = User::query()->forceCreate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
        $gridKey = 'test-grid';

        $setting = DataGridSetting::query()->create([
            'owner_id' => $user->getAuthIdentifier(),
            'data_grid_key' => $gridKey,
            'name' => 'Test Setting',
            'value' => ['test' => 'value'],
        ]);

        $resolver = new OwnedDataGridSettingResolver;
        $result = $resolver->resolve($user, $gridKey);

        $this->assertCount(1, $result);
        $this->assertTrue($result->contains($setting));
    }

    public function test_resolve_returns_empty_collection_when_no_settings_match()
    {
        $owningUser = User::query()->forceCreate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
        $gridKey = 'test-grid';

        DataGridSetting::query()->create([
            'owner_id' => $owningUser->getAuthIdentifier(),
            'data_grid_key' => $gridKey,
            'name' => 'Test Setting',
            'value' => ['test' => 'value'],
        ]);

        $user = User::query()->forceCreate([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);

        $resolver = new OwnedDataGridSettingResolver;
        $result = $resolver->resolve($user, $gridKey);

        $this->assertCount(0, $result);
    }
}
