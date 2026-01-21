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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->bigInteger('strength_id');
            $table->string('title')->nullable();
            $table->integer('qty');
            $table->decimal('mrp', 6, 2)->nullable();
            $table->decimal('price', 6, 2)->nullable();
            $table->decimal('sale_price', 6, 2);
            $table->string('thumb')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('position')->default(0);
            $table->unsignedTinyInteger('preferred')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('created_by')->default(0);
            $table->unsignedTinyInteger('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
