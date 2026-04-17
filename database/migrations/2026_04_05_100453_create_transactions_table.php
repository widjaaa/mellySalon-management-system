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
            $table->string('invoice_number')->unique();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->string('customer_name');
            $table->string('services_summary');
            $table->integer('subtotal')->default(0);
            $table->integer('discount_amount')->default(0);
            $table->integer('total_amount');
            $table->string('payment_method'); // Tunai, QRIS, Transfer
            $table->integer('cash_received')->nullable();
            $table->integer('cash_change')->nullable();
            $table->integer('poin_awarded')->default(0);
            $table->string('status')->default('completed'); // completed, voided
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->nullOnDelete();
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
