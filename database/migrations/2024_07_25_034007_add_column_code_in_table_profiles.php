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
        if(!Schema::hasColumn('profiles','code')){
            Schema::table('profiles', function (Blueprint $table) {
               $table->string('code')->unique()->nullable(); 
            });
        }
        if(!Schema::hasColumn('profiles','related_code')){
            Schema::table('profiles', function (Blueprint $table) {
               $table->string('related_code')->nullable(); 
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
