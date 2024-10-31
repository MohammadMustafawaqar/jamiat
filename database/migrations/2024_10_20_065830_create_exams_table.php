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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('grade_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('province_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('district_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->date('start_date')
                ->nullable();
            $table->date('end_date')
                ->nullable();
            $table->string('address')
                ->nullable();
            $table->text('description')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
