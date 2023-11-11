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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('automated_teller_machine_id');
            $table->unsignedBigInteger('transfer_id');
            $table->timestamps();

            $table->foreign('automated_teller_machine_id')->references('id')->on('automated_teller_machines');
            $table->foreign('transfer_id')->references('id')->on('transfers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
