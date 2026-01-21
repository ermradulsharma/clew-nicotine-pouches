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
        Schema::create('wp_links', function (Blueprint $table) {
            $table->bigIncrements('link_id');
            $table->string('link_url', 255)->default('');
            $table->string('link_name', 255)->default('');
            $table->string('link_image', 255)->default('');
            $table->string('link_target', 25)->default('');
            $table->string('link_description', 255)->default('');
            $table->string('link_visible', 20)->default('Y');
            $table->unsignedBigInteger('link_owner')->default(1);
            $table->integer('link_rating')->default(0);
            $table->dateTime('link_updated')->nullable();
            $table->string('link_rel', 255)->default('');
            $table->mediumText('link_notes');
            $table->string('link_rss', 255)->default('');

            $table->index('link_visible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wp_links');
    }
};
