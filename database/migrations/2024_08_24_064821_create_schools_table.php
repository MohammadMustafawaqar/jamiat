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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->foreignId("address_type_id")->constrained()->cascadeOnDelete();
            $table->foreignId("province_id")
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId("district_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->string('village')
                ->nullable();
            $table->string("name");

            $table->text("details")->nullable();
            $table->string('status')
                ->default('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
