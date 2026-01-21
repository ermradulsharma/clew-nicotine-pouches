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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->mediumText('tagline')->nullable();
            $table->longText('description')->nullable();
            $table->mediumText('pageTitle')->nullable();
            $table->mediumText('pageDescription')->nullable();
            $table->mediumText('pageKeywords')->nullable();
            $table->string('slug');
            $table->unsignedBigInteger('position')->default(0);
            $table->unsignedTinyInteger('featured')->default(0);
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
        Schema::dropIfExists('categories');
    }
};
