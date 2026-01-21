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
        Schema::create('cart_temps', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->integer('user_id')->nullable();
            $table->integer('category_id');
            $table->string('category_name');
            $table->integer('product_id');
            $table->string('product_name');
            $table->string('sku_code');
            $table->string('product_image')->nullable();
            $table->integer('variant_id');
            $table->string('variant_name')->nullable();
            $table->integer('variant_qty');
            $table->decimal('unit_mrp', 10, 2)->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->integer('qty');
            $table->decimal('base_discount', 10, 2)->default(0.00);
            $table->decimal('incremental_discount', 10, 2)->default(0.00);
            $table->decimal('max_discount', 10, 2)->default(0.00);
            $table->decimal('total_discount_amount', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_temps');
    }
};
