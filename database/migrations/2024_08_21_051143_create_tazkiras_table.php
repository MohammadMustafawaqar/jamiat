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
        Schema::create('tazkiras', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['paper', 'electric'])
                ->default('electric');
            $table->string('tazkira_no');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tazkiras');
    }
};
