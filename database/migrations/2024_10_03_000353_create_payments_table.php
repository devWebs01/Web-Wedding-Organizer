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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel orders
            $table->string('payment_type'); // Jenis pembayaran (DP atau Lunas)
            $table->string('amount'); // Jumlah uang yang dibayarkan
            $table->dateTime('payment_date'); // Tanggal pembayaran
            $table->string('payment_status'); // Status pembayaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
