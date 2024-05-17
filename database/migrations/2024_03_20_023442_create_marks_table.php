<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.bb 
     */
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_student_id')->constrained('classroom_students')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('assignment_id')->constrained('assignments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
