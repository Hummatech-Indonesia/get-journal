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
        if(!Schema::hasColumn('profiles','is_premium_private')){
            Schema::table('profiles', function (Blueprint $table) {
                $table->tinyInteger('is_premium_private');
            });
        }
        if(!Schema::hasColumn('profiles','is_premium_school')){
            Schema::table('profiles', function (Blueprint $table) {
                $table->tinyInteger('is_premium_school');
            });
        }
        if(!Schema::hasColumn('profiles','quantity_premium')){
            Schema::table('profiles', function (Blueprint $table) {
                $table->integer('quantity_premium');
            });
        }
        if(!Schema::hasColumn('profiles','used_quantity_premium')){
            Schema::table('profiles', function (Blueprint $table) {
                $table->integer('used_quantity_premium');
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
