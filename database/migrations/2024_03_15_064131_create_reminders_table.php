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
        Schema::create('reminders', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->foreignUuid('profile_id')->constrained('profiles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->text('content');
            $table->dateTime('reminder_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
