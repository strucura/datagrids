<?php

namespace Strucura\DataGrid\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Strucura\DataGrid\Http\Requests\GridDataRequest;
use Strucura\DataGrid\Http\Requests\GridSchemaRequest;
use Strucura\DataGrid\Http\Requests\RetrieveDataGridSettingsRequest;
use Strucura\DataGrid\Models\DataGridSetting;
use Strucura\DataGrid\Tests\Fakes\UserGrid;

class UserGridTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function testGetsGridDataCorrectly()
    {
        // Seed the database with test data
        DB::table('users')->insert([
            ['name' => 'John Doe', 'email' => 'john@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Create a GridDataRequest with necessary inputs
        $request = GridDataRequest::create('/grid-data', 'GET', [
            'first' => 0,
            'last' => 100,
            'filters' => [],
            'sorts' => [],
        ]);

        // Create an instance of UserGrid
        $grid = new UserGrid;

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

    public function testGetsGridSchemaCorrectly()
    {
        // Create an instance of UserGrid
        $grid = new UserGrid;

        // Call the handleSchema method
        $response = $grid->handleSchema(GridSchemaRequest::create($grid->getRoutePath(), 'POST'));

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

    public function testRetrievesGridSettingsCorrectly()
    {
        $user = User::query()->forceCreate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $grid = new UserGrid;

        DataGridSetting::query()->create([
            'owner_id' => $user->id,
            'grid_key' => $grid->getDataGridKey(),
            'name' => 'setting1',
            'value' => json_encode(['foo' => 'bar']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DataGridSetting::query()->create([
            'owner_id' => $user->id,
            'grid_key' => $grid->getDataGridKey(),
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

    public function testGetsDataGridKeyCorrectly()
    {
        // Create an instance of UserGrid
        $grid = new UserGrid;

        // Call the getDataGridKey method
        $key = $grid->getDataGridKey();

        // Assert that the returned key matches the expected key
        $this->assertEquals('grids.users', $key);
    }
}
