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
        Schema::create('sub_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')
                ->constrained()
                ->cascadeOnDelete();
                
            $table->string('name');
            $table->integer('capacity');
            $table->string('status')
                ->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_classes');
    }
};
