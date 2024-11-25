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
            $table->unsignedBigInteger('student_id')->nullable()->change();
            // Drop the existing foreign key

            // Add the new foreign key with null on delete
            $table->foreign('student_id')->references('id')->on('students')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_forms', function (Blueprint $table) {
            // Drop the modified foreign key
            $table->dropForeign(['student_id']);

            $table->unsignedBigInteger('student_id')->nullable(false)->change();

            // Re-add the original foreign key with cascade on delete
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
        });
    }
};
