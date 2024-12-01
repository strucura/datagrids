<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_grid_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('datagrids.models.user'), 'owner_id')->constrained()->cascadeOnDelete();
            $table->string('data_grid_key');
            $table->string('name');
            $table->json('value');
            $table->timestamps();

            $table->unique(['owner_id', 'data_grid_key', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_grid_settings');
    }
};
