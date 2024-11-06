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
        Schema::create('data_grid_setting_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('data-grid-settings.models.data_grid_setting'))->constrained()->cascadeOnDelete();
            $table->foreignIdFor(config('data-grid-settings.models.user'))->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_grid_setting_user');
    }
};
