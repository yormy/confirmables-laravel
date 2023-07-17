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
        Schema::create('confirmables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('payload');
            $table->longText('arguments')->nullable();

            $table->boolean('email_required')->nullable();
            $table->boolean('phone_required')->nullable();

            $table->date('email_verified_at')->nullable();
            $table->string('email_verified_from')->nullable();

            $table->date('phone_verified_at')->nullable();
            $table->string('phone_verified_from')->nullable();

            $table->date('executed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
