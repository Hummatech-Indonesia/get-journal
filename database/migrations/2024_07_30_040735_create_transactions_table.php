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
        if(Schema::hasTable("transactions")) return;

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->string('merchant_ref')->nullable();
            $table->string('payment_selection_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('callback_url')->nullable();
            $table->string('return_url')->nullable();
            $table->double('amount')->default(0);
            $table->double('fee_merchant')->default(0);
            $table->double('fee_customer')->default(0);
            $table->double('total_fee')->default(0);
            $table->double('amount_received')->default(0);
            $table->string('pay_code')->nullable();
            $table->string('pay_url')->nullable();
            $table->string('checkout_url')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('expired_time')->nullable();
            $table->json('order_items')->nullable();
            $table->json('instructions')->nullable();
            $table->string('qr_string')->nullable();
            $table->string('qr_url')->nullable();
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
