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
        if(!Schema::hasColumn('password_resets', 'user_id')){
            Schema::table('password_resets', function (Blueprint $table) {
                $table->foreignUuid('user_id')->nullable()->constrained();
            });
        }
        if(!Schema::hasColumn('password_resets', 'expired_at')){
            Schema::table('password_resets', function (Blueprint $table) {
                $table->dateTime('expired_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_resets', function (Blueprint $table) {
            //
        });
    }
};
