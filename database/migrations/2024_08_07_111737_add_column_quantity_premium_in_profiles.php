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
        if(!Schema::hasColumn('profiles','user_premium_private_id')){
            Schema::table('profiles', function (Blueprint $table) {
                $table->foreignUuid('user_premium_private_id')->nullable()->constrained('users');
            });
        }
        if(!Schema::hasColumn('profiles','user_premium_school_id')){
            Schema::table('profiles', function (Blueprint $table) {
                $table->foreignUuid('user_premium_school_id')->nullable()->constrained('users');
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
