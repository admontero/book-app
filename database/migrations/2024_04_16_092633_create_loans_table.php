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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('copy_id');
            $table->unsignedBigInteger('user_id');
            $table->date('start_date');
            $table->date('limit_date');
            $table->date('devolution_date')->nullable();
            $table->boolean('is_fineable')->default(true);
            $table->decimal('fine_amount')->nullable();
            $table->string('status')->default('en curso');
            $table->string('serial')->unique()->nullable();
            $table->unsignedBigInteger('serial_number')->unique()->nullable();

            $table->foreign('copy_id')->references('id')->on('copies')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
