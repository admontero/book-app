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
        Schema::create('copies', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->boolean('is_loanable')->default(true);
            $table->unsignedBigInteger('edition_id');
            $table->string('status')->default('disponible');

            $table->foreign('edition_id')->references('id')->on('editions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copies');
    }
};
