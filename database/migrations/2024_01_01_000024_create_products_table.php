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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->string('title');
            $table->unsignedBigInteger('flavour_id');
            $table->mediumText('tagline')->nullable();
            $table->unsignedBigInteger('label_id')->nullable();
            $table->string('sku_code');
            $table->decimal('mrp', 6, 2)->nullable();
            $table->decimal('price', 6, 2)->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->string('banner')->nullable();
            $table->string('banner_alt_tag')->nullable();
            $table->decimal('base_discount', 6, 2)->default(0.00);
            $table->decimal('incremental_discount', 6, 2)->default(0.00);
            $table->decimal('max_discount', 6, 2)->default(0.00);
            $table->mediumText('short_description')->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('pageTitle')->nullable();
            $table->mediumText('pageDescription')->nullable();
            $table->mediumText('pageKeywords')->nullable();
            $table->text('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->text('og_image')->nullable();
            $table->text('og_alt_tag')->nullable();
            $table->text('robots_tag')->nullable();
            $table->mediumText('searchKeywords')->nullable();
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('showOnCart')->default(0);
            $table->unsignedBigInteger('position')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->tinyInteger('visible')->default(0);
            $table->unsignedTinyInteger('created_by')->default(0);
            $table->string('restricted_state', 256)->nullable();
            $table->unsignedTinyInteger('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
