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
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_type');
            $table->string('amount');
            $table->date('payment_date');
            $table->enum('payment_status', ['UNPAID_PAYMENT', 'WAITING_CONFIRM_PAYMENT', 'CONFIRM_PAYMENT', 'REJECT_PAYMENT', 'PARTIAL_PAYMENT']);
            $table->string('proof_of_payment')->nullable();
            $table->longText('note')->nullable();
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
