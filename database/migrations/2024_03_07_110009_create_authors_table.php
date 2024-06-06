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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_birth_id')->nullable();
            $table->unsignedBigInteger('state_birth_id')->nullable();
            $table->unsignedBigInteger('city_birth_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('first_surname')->nullable();
            $table->string('second_surname')->nullable();
            $table->string('full_name')->virtualAs('CONCAT_WS(" ", first_name, middle_name, first_surname, second_surname)');
            $table->string('slug')->unique();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death')->nullable();
            $table->string('photo_path', 2048)->nullable();

            $table->foreign('country_birth_id')
                ->references('id')
                ->on('countries')
                ->nullOnDelete();

            $table->foreign('state_birth_id')
                ->references('id')
                ->on('states')
                ->nullOnDelete();

            $table->foreign('city_birth_id')
                ->references('id')
                ->on('cities')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
