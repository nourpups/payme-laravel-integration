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
        Schema::create('payme_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('transaction')->nullable();
            $table->string('order_id')->nullable();
            $table->string('code')->nullable();
            $table->string('state')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->string('reason')->nullable();
            $table->string('pay_time')->nullable();
            $table->string('create_time')->nullable();
            $table->string('perform_time')->nullable();
            $table->string('cancel_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payme_transaction');
    }
};
