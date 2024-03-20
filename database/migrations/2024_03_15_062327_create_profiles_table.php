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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('identity_number');
            $table->string('name');
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->enum('is_register', [0, 1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
