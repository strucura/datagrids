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
            $table->unsignedBigInteger('data_grid_setting_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('data_grid_setting_id')->references('id')->on('data_grid_settings')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
