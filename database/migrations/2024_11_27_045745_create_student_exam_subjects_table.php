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
        Schema::create('student_exam_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_exam_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('exam_subject_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('score');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exam_subjects');
    }
};
