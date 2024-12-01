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
        Schema::table('student_exams', function (Blueprint $table) {
            $table->foreignId('appreciation_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->float('score_avg')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_exams', function (Blueprint $table) {
            $table->dropConstrainedForeignId('appreciation_id');
            $table->dropColumn('score_avg');
        });
    }
};
