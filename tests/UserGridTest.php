<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Strucura\DataGrid\Http\Requests\GridDataRequest;
use Strucura\DataGrid\Http\Requests\GridSchemaRequest;
use Strucura\DataGrid\Http\Requests\PersistDataGridSettingRequest;
use Strucura\DataGrid\Http\Requests\RetrieveDataGridSettingsRequest;
use Strucura\DataGrid\Http\Resources\DataGridSettingResource;
use Strucura\DataGrid\Models\DataGridSetting;
use Strucura\DataGrid\Tests\Fakes\UserGrid;

beforeEach(function () {
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->timestamps();
    });
});

afterEach(function () {
    Schema::dropIfExists('users');
});

it('gets grid data correctly', function () {
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
    expect($response)->toBeInstanceOf(JsonResponse::class);

    // Assert that the response data matches the expected data
    $data = $response->getData(true);

    expect($data)->toHaveCount(2)
        ->and($data[0]['ID'])->toBe(1)
        ->and($data[0]['Name'])->toBe('John Doe')
        ->and($data[0]['Email'])->toBe('john@example.com')

        ->and($data[1]['ID'])->toBe(2)
        ->and($data[1]['Name'])->toBe('Jane Doe')
        ->and($data[1]['Email'])->toBe('jane@example.com');
});

it('gets grid schema correctly', function () {
    // Create an instance of UserGrid
    $grid = new UserGrid;

    // Call the handleSchema method
    $response = $grid->handleSchema(GridSchemaRequest::create($grid->getRoutePath(), 'POST'));

    // Assert that the response is a JsonResponse
    expect($response)->toBeInstanceOf(JsonResponse::class);

    // Assert that the response data matches the expected schema
    $data = $response->getData(true);

    expect($data)->toHaveCount(3);

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
        expect($data)->toContainEqual($column);
    }
});

it('retrieves grid settings correctly', function () {
    $grid = new UserGrid;

    DataGridSetting::query()->create([
        'owner_id' => 1,
        'grid_key' => $grid->getDataGridKey(),
        'name' => 'setting1',
        'value' => json_encode(['foo' => 'bar']),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    DataGridSetting::query()->create([
        'owner_id' => 1,
        'grid_key' => $grid->getDataGridKey(),
        'name' => 'setting2',
        'value' => json_encode(['baz' => 'qux']),
        'created_at' => now(),
        'updated_at' => now()],
    );

    // Create a RetrieveDataGridSettingsRequest
    $request = RetrieveDataGridSettingsRequest::create($grid->getRoutePath(), 'GET', []);

    // Call the handleRetrievingSettings method
    $response = $grid->handleRetrievingSettings($request);

    // Assert that the response is an AnonymousResourceCollection
    expect($response)->toBeInstanceOf(AnonymousResourceCollection::class);

    // Assert that the response data matches the expected settings
    $data = $response->toArray($request);

    expect($data)->toHaveCount(2)
        ->and($data[0]['name'])->toBe('setting1')
        ->and($data[0]['value'])->toBe(['foo' => 'bar'])
        ->and($data[1]['name'])->toBe('setting2')
        ->and($data[1]['value'])->toBe(['baz' => 'qux']);
});

it('gets data grid key correctly', function () {
    // Create an instance of UserGrid
    $grid = new UserGrid;

    // Call the getDataGridKey method
    $key = $grid->getDataGridKey();

    // Assert that the returned key matches the expected key
    expect($key)->toBe('grids.users');
});
