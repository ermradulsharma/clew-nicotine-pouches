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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code');
            $table->decimal('discount', 8, 2);
            $table->string('discount_type');
            $table->integer('units');
            $table->string('products')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('usage_limit')->default(0);
            $table->integer('used')->default(0);
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('created_by')->default(0);
            $table->unsignedTinyInteger('updated_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
