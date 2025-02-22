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
        Schema::table('student_forms', function (Blueprint $table) {
            $table->string('qamari_year')
                ->default('1446');
            $table->string('shamsi_year')
                ->default('1403');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_forms', function (Blueprint $table) {
            $table->dropColumn(['qamari_year', 'shamsi_year']);
            
        });
    }
};
