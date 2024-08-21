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
        if(!Schema::hasColumn('payment_channels','icon_url')){
            Schema::table('payment_channels', function (Blueprint $table) {
                $table->string('icon_url')->nullable();
            });
        }
        if(!Schema::hasColumn('payment_channels','active')){
            Schema::table('payment_channels', function (Blueprint $table) {
                $table->tinyInteger('active')->default(1);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
