<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function ($table) {
            $table->id();
            $table->string('type', 255);
            $table->string('name', 255);
            $table->string('postal_code', 255);
            $table->bigInteger('province_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('cities');
    }
};
