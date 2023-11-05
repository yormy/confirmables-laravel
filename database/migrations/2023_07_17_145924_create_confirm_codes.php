<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Yormy\ConfirmablesLaravel\Models\Confirmable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('confirmable_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Confirmable::class);

            $table->string('code');
            $table->string('method');
            $table->string('token')->nullable();

            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->string('user_type')->nullable();

            $table->dateTime('expires_at')->nullable();
            $table->string('accept_from_ip')->nullable();



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
