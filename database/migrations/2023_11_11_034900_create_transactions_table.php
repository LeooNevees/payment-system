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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_account_id');
            $table->unsignedBigInteger('transfer_id');
            $table->enum('type', ['D', 'C']);
            $table->float('value', 10, 2);
            $table->timestamps();

            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->foreign('transfer_id')->references('id')->on('transfers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
