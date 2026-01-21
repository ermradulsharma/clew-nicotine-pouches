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
        Schema::create('coupon_temps', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->bigInteger('coupon_id');
            $table->string('coupon_code');
            $table->string('discount_type');
            $table->integer('discount');
            $table->string('products')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_temps');
    }
};
