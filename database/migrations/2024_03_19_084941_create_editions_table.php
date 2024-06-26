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
        Schema::create('editions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('editorial_id');
            $table->string('slug')->unique();
            $table->string('isbn13')->unique()->nullable();
            $table->integer('pages')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('cover_path', 2048)->nullable();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('editorial_id')->references('id')->on('editorials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editions');
    }
};
