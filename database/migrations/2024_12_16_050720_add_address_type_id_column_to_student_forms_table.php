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
            $table->foreignId('address_type_id')
                ->after('student_id')
                ->default(1)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_forms', function (Blueprint $table) {
            $table->dropConstrainedForeignId('address_type_id');
        });
    }
};
