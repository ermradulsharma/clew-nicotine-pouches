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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('thumb')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_tag')->nullable();
            $table->mediumText('pageTitle')->nullable();
            $table->mediumText('pageDescription')->nullable();
            $table->mediumText('pageKeywords')->nullable();
            $table->text('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->text('og_image')->nullable();
            $table->text('og_alt_tag')->nullable();
            $table->text('robots_tag')->nullable();
            $table->string('slug');
            $table->longText('content')->nullable();
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
        Schema::dropIfExists('pages');
    }
};
