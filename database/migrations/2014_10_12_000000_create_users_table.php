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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('user_type');
            $table->string('document')->unique();
            $table->string('password');
            $table->char('status', 1)->default('A');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_type')->references('id')->on('user_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
