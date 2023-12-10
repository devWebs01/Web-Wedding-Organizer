<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  'user_id', 'status', 'invoice', 'total', 'resi', 'ongkir', 'payment'
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice')->nullable();
            $table->string('status')->nullable();
            $table->string('total')->nullable();
            $table->string('weight')->nullable();
            $table->string('resi')->nullable();
            $table->string('ongkir')->nullable();
            $table->string('payment')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
