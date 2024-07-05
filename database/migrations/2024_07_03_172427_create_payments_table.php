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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fine_id');
            $table->string('reference')->unique();
            $table->string('pay_u_reference')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_method_name')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('transaction_at')->nullable();
            $table->tinyInteger('transaction_state')->nullable();

            $table->foreign('fine_id')->references('id')->on('fines')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
