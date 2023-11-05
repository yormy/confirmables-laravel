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
        Schema::create('confirmable_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('xid')->unique();
            $table->longText('payload');
            $table->longText('arguments')->nullable();
            $table->longText('success_response')->nullable();

            $table->boolean('email_required')->nullable();
            $table->boolean('phone_required')->nullable();

            $table->string('email_code_title')->nullable();
            $table->string('email_code_description')->nullable();
            $table->string('phone_code_title')->nullable();
            $table->string('phone_code_description')->nullable();

            $table->datetime('email_verified_at')->nullable();
            $table->string('email_verified_from')->nullable();

            $table->datetime('phone_verified_at')->nullable();
            $table->string('phone_verified_from')->nullable();

            $table->datetime('dispatched_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
