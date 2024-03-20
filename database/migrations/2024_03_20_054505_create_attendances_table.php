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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('journal_id')->constrained('journals')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('profile_id')->constrained('profiles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status', ['permit', 'sick', 'alpha']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
