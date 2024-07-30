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
        Schema::create('payment_channels', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->double('min_amount')->default(0);
            $table->double('max_amount')->default(0);
            $table->integer('min_expired')->default(0);
            $table->integer('max_expired')->default(0);
            $table->string('time_expired')->default('minute');
            $table->string('type')->default('direct');
            $table->double('tax')->default(0);
            $table->tinyInteger('is_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_channels');
    }
};
