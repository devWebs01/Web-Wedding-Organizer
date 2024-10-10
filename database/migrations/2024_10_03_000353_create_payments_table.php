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
            $table->string('payment_type'); // Jenis pembayaran (DP atau Tunai)
            $table->string('amount'); // Jumlah uang yang dibayarkan
            $table->date('payment_date'); // Tanggal pembayaran
            $table->enum('payment_status', ['UNPAID', 'PENDING', 'CONFIRMED']); // Status pembayaran
            $table->string('proof_of_payment')->nullable(); // Status pembayaran
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
