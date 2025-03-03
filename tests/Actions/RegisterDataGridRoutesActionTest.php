<?php

namespace Strucura\DataGrid\Tests\Actions;

use Illuminate\Support\Facades\Route;
use Spatie\StructureDiscoverer\Discover;
use Strucura\DataGrid\Actions\RegisterDataGridRoutesAction;
use Strucura\DataGrid\Tests\Fakes\UserDataGrid;
use Strucura\DataGrid\Tests\TestCase;

class RegisterDataGridRoutesActionTest extends TestCase
{
    public function testHandleRegistersRoutes()
    {
        // Mock the Discover class
        $this->mock(Discover::class, function ($discoverMock) {
            $discoverMock->shouldReceive('in')->andReturnSelf();
            $discoverMock->shouldReceive('any')->andReturnSelf();
            $discoverMock->shouldReceive('get')->andReturn([
                UserDataGrid::class,
            ]);
        });

        // Call the handle method
        $action = RegisterDataGridRoutesAction::make();
        $action->handle();

        // Assert the routes are registered
        $this->assertTrue(Route::has('user.grid.data'));
        $this->assertTrue(Route::has('user.grid.schema'));
    }
}
