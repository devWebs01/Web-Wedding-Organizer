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
            $table->string('slug')->nullable();
            $table->enum('status', ['UNPAID_ORDER', 'DRAF_ORDER', 'FINISH_ORDER', 'PENDING_ORDER', 'CANCEL_ORDER', 'PARTIAL', 'ACCEPT_ORDER']);
            $table->unsignedBigInteger('total_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->longText('note')->nullable();
            // add field more
            $table->dateTime('wedding_date')->nullable();
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
