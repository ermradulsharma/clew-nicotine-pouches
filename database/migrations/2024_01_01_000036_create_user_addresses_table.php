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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile');
            $table->mediumText('address');
            $table->string('apartment')->nullable();
            $table->string('city');
            $table->string('state');
            $table->unsignedInteger('state_id');
            $table->unsignedBigInteger('pincode');
            $table->string('country');
            $table->integer('country_id');
            $table->unsignedInteger('otp')->nullable();
            $table->tinyInteger('verified')->default(0);
            $table->unsignedTinyInteger('preferred')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
