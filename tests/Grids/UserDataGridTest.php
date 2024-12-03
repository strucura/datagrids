<?php

namespace Strucura\DataGrid\Tests\Grids;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Strucura\DataGrid\Http\Requests\DataGridDataRequest;
use Strucura\DataGrid\Http\Requests\DataGridSchemaRequest;
use Strucura\DataGrid\Http\Requests\RetrieveDataGridSettingsRequest;
use Strucura\DataGrid\Models\DataGridSetting;
use Strucura\DataGrid\Tests\Fakes\UserDataGrid;
use Strucura\DataGrid\Tests\TestCase;

class UserDataGridTest extends TestCase
{
    public function test_gets_grid_data_correctly()
    {
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

        $this->assertEquals(2, $data['row_count']);
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

        // Call the handleSchema method
        $response = $grid->handleSchema(DataGridSchemaRequest::create($grid->getRoutePath(), 'POST'));

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Assert that the response data matches the expected schema
        $data = $response->getData(true);

        $this->assertCount(3, $data['columns']);

        $columns = [
            [
                'field' => 'ID',
                'header' => 'ID',
                'column_type' => 'integer',
                'sortable' => true,
                'filterable' => true,
                'hidden' => false,
                'meta' => [],
            ],
            [
                'field' => 'Name',
                'header' => 'Name',
                'column_type' => 'string',
                'sortable' => true,
                'filterable' => true,
                'hidden' => false,
                'meta' => [],
            ],
            [
                'field' => 'Email',
                'header' => 'Email',
                'column_type' => 'string',
                'sortable' => true,
                'filterable' => true,
                'hidden' => false,
                'meta' => [],
            ],
        ];

        foreach ($columns as $column) {
            $this->assertContains($column, $data['columns']);
        }
    }

    public function test_retrieves_grid_settings_correctly()
    {
        $user = User::query()->forceCreate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $grid = new UserDataGrid;

        DataGridSetting::query()->create([
            'owner_id' => $user->id,
            'data_grid_key' => $grid->getDataGridKey(),
            'name' => 'setting1',
            'value' => json_encode(['foo' => 'bar']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DataGridSetting::query()->create([
            'owner_id' => $user->id,
            'data_grid_key' => $grid->getDataGridKey(),
            'name' => 'setting2',
            'value' => json_encode(['baz' => 'qux']),
            'created_at' => now(),
            'updated_at' => now()],
        );

        // Create a RetrieveDataGridSettingsRequest
        $request = RetrieveDataGridSettingsRequest::create($grid->getRoutePath(), 'GET', []);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Call the handleRetrievingSettings method
        $response = $grid->handleRetrievingSettings($request);

        // Assert that the response is an AnonymousResourceCollection
        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);

        // Assert that the response data matches the expected settings
        $data = $response->toArray($request);

        $this->assertCount(2, $data);
        $this->assertEquals('setting1', $data[0]['name']);
        $this->assertEquals(json_encode(['foo' => 'bar']), $data[0]['value']);
        $this->assertEquals('setting2', $data[1]['name']);
        $this->assertEquals(json_encode(['baz' => 'qux']), $data[1]['value']);
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
