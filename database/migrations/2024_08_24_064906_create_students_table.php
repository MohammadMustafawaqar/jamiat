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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_type_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId("user_id")
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId("current_district_id")
                ->constrained('districts')
                ->cascadeOnDelete();
            $table->foreignId("permanent_district_id")
                ->constrained('districts')
                ->cascadeOnDelete();
            $table->foreignId("sub_category_id")
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId("school_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId("gender_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId("appreciation_id")
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string("form_id");
            $table->string("name");
            $table->string("name_en")
                ->nullable();
            $table->string("last_name");
            $table->string("last_name_en")
                ->nullable();
            $table->string("father_name");
            $table->string("father_name_en")
                ->nullable();
            $table->string("grand_father_name");
            $table->string("grand_father_name_en")
                ->nullable();
            $table->string("current_village")
                ->nullable();
            $table->string("permanent_village")
                ->nullable();
            $table->date("dob")
                ->nullable();
            $table->string("dob_qamari")
                ->nullable();
            $table->string("dob_shamsi")
                ->nullable();
            $table->integer("graduation_year")
                ->nullable();
            $table->string('phone');
            $table->string('whatsapp')
                ->nullable();
            $table->string("image_path")
                ->nullable();
            $table->foreignId('tazkira_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
