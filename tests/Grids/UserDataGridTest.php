<?php

namespace Strucura\DataGrid\Tests\Grids;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Strucura\DataGrid\Http\Requests\DataGridDataRequest;
use Strucura\DataGrid\Http\Requests\DataGridSchemaRequest;
use Strucura\DataGrid\Tests\Fakes\UserDataGrid;
use Strucura\DataGrid\Tests\Fakes\UserDataGridWithAuthorization;
use Strucura\DataGrid\Tests\TestCase;

class UserDataGridTest extends TestCase
{
    public function test_gets_grid_data_correctly()
    {
        // Create an instance of UserDataDataGrid
        $grid = new UserDataGrid;

        // Mock the Gate facade to bypass authorization with specific permission
        Gate::shouldReceive('authorize')->never();

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

        // Call the handleData method
        $response = $grid->handleData($request);

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Assert that the response data matches the expected data
        $data = $response->getData(true);

        $this->assertEquals(2, $data['total_row_count']);
        $rows = $data['rows'];
        $this->assertCount(2, $rows);
        $this->assertEquals(1, $rows[0]['ID']);
        $this->assertEquals('John Doe', $rows[0]['Name']);
        $this->assertEquals('john@example.com', $rows[0]['Email']);
        $this->assertEquals(2, $rows[1]['ID']);
        $this->assertEquals('Jane Doe', $rows[1]['Name']);
        $this->assertEquals('jane@example.com', $rows[1]['Email']);
    }

    public function test_gets_grid_schema_correctly()
    {
        // Create an instance of UserDataDataGrid
        $grid = new UserDataGrid;

        // Mock the Gate facade to bypass authorization with specific permission
        Gate::shouldReceive('authorize')->never();

        // Call the handleSchema method
        $response = $grid->handleSchema(DataGridSchemaRequest::create($grid->getRoutePath(), 'POST'));

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Assert that the response data matches the expected schema
        $data = $response->getData(true);

        $this->assertCount(3, $data['columns']);

        $columns = [
            [
                'alias' => 'ID',
                'type' => 'integer',
                'is_sortable' => true,
                'is_filterable' => true,
                'is_hidden' => false,
                'meta' => [],
            ],
            [
                'alias' => 'Name',
                'type' => 'string',
                'is_sortable' => true,
                'is_filterable' => true,
                'is_hidden' => false,
                'meta' => [],
            ],
            [
                'alias' => 'Email',
                'type' => 'string',
                'is_sortable' => true,
                'is_filterable' => true,
                'is_hidden' => false,
                'meta' => [],
            ],
        ];

        foreach ($columns as $column) {
            $this->assertContains($column, $data['columns']);
        }
    }

    public function test_invokes_permission_check_when_permission_trait_present_on_data()
    {
        $grid = new UserDataGridWithAuthorization;

        // Mock the Gate facade to bypass authorization with specific permission
        Gate::shouldReceive('authorize')
            ->with($grid->getPermissionName())
            ->andReturn(true);

        // Create a DataGridDataRequest with necessary inputs
        $request = DataGridDataRequest::create('/grid-data', 'GET', [
            'first' => 0,
            'last' => 100,
            'filters' => [],
            'sorts' => [],
        ]);

        // Call the handleData method
        $response = $grid->handleData($request);

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function test_invokes_permission_check_when_permission_trait_present_on_schema()
    {
        $grid = new UserDataGridWithAuthorization;

        // Mock the Gate facade to bypass authorization with specific permission
        Gate::shouldReceive('authorize')
            ->with($grid->getPermissionName())
            ->andReturn(true);

        // Call the handleSchema method
        $response = $grid->handleSchema(DataGridSchemaRequest::create($grid->getRoutePath(), 'POST'));

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function test_creates_permission_name_correctly()
    {
        // Create an instance of UserDataDataGrid
        $grid = new UserDataGridWithAuthorization;

        // Call the getPermissionName method
        $name = $grid->getPermissionName();

        // Assert that the returned name matches the expected name
        $this->assertEquals('user_data_grid_with_authorization', $name);
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
}
