<?php

namespace Strucura\DataGrid\Tests\Grids;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Strucura\DataGrid\Http\Requests\DataGridDataRequest;
use Strucura\DataGrid\Http\Requests\DataGridSchemaRequest;
use Strucura\DataGrid\Tests\Fakes\UserDataGrid;
use Strucura\DataGrid\Tests\TestCase;

class UserDataGridTest extends TestCase
{
    public function test_gets_grid_data_correctly()
    {
        $mock = $this->partialMock(Gate::class, function ($mock) {
            $mock->shouldReceive('authorize')->with('user_data_grid')->once()->andReturn(true);
        });
        $this->app->instance(Gate::class, $mock);

        // Seed the database with test data
        DB::table('users')->insert([
            ['name' => 'John Doe', 'email' => 'john@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Create a DataGridDataRequest with necessary inputs
        $request = DataGridDataRequest::create('/grid-data', 'GET', [
            'first' => 0,
            'last' => 100,
            'filters' => [],
            'sorts' => [],
        ]);

        // Create an instance of UserDataDataGrid
        $grid = new UserDataGrid;

        // Call the handleData method
        $response = $grid->handleData($request);

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Assert that the response data matches the expected data
        $data = $response->getData(true);

        $this->assertCount(2, $data);
        $this->assertEquals(1, $data[0]['ID']);
        $this->assertEquals('John Doe', $data[0]['Name']);
        $this->assertEquals('john@example.com', $data[0]['Email']);
        $this->assertEquals(2, $data[1]['ID']);
        $this->assertEquals('Jane Doe', $data[1]['Name']);
        $this->assertEquals('jane@example.com', $data[1]['Email']);
    }

    public function test_gets_grid_schema_correctly()
    {
        $mock = $this->partialMock(Gate::class, function ($mock) {
            $mock->shouldReceive('authorize')->with('user_data_grid')->once()->andReturn(true);
        });
        $this->app->instance(Gate::class, $mock);

        // Create an instance of UserDataDataGrid
        $grid = new UserDataGrid;

        // Call the handleSchema method
        $response = $grid->handleSchema(DataGridSchemaRequest::create($grid->getRoutePath(), 'POST'));

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Assert that the response data matches the expected schema
        $data = $response->getData(true);

        $this->assertCount(3, $data);

        $columns = [
            [
                'field' => 'ID',
                'header' => 'ID',
                'data_type' => 'integer',
                'sortable' => true,
                'filterable' => true,
                'hidden' => false,
                'meta' => [],
            ],
            [
                'field' => 'Name',
                'header' => 'Name',
                'data_type' => 'string',
                'sortable' => true,
                'filterable' => true,
                'hidden' => false,
                'meta' => [],
            ],
            [
                'field' => 'Email',
                'header' => 'Email',
                'data_type' => 'string',
                'sortable' => true,
                'filterable' => true,
                'hidden' => false,
                'meta' => [],
            ],
        ];

        foreach ($columns as $column) {
            $this->assertContains($column, $data);
        }
    }

    public function test_gets_data_grid_key_correctly()
    {
        // Create an instance of UserDataDataGrid
        $grid = new UserDataGrid;

        // Call the getDataGridKey method
        $key = $grid->getDataGridKey();

        // Assert that the returned key matches the expected key
        $this->assertEquals('grids.users', $key);
    }

    public function test_gets_permission_name_correctly()
    {
        // Create an instance of UserDataDataGrid
        $grid = new UserDataGrid;

        // Call the getPermissionName method
        $permissionName = $grid->getPermissionName();

        // Assert that the returned permission name matches the expected permission name
        $this->assertEquals('user_data_grid', $permissionName);
    }
}
