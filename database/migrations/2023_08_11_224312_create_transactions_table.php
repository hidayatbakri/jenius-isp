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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('olt_id');
            $table->foreignId('customer_id');
            $table->string('status_code');
            $table->string('transaction_id')->nullable();
            $table->string('order_id');
            $table->string('gross_amount');
            $table->string('payment_type')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('paymentlink');
            $table->timestamp('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
