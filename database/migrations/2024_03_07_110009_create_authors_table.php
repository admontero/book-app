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
            $table->string('firstname');
            $table->string('lastname');
            $table->string('pseudonym')->nullable();
            $table->string('slug')->unique();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death')->nullable();
            $table->longText('biography')->nullable();
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
