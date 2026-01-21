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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('tagline')->nullable();
            $table->char('bannerType', 10);
            $table->string('thumb')->nullable();
            $table->string('image')->nullable();
            $table->string('poster')->nullable();
            $table->string('video')->nullable();
            $table->mediumText('redirect_url')->nullable();
            $table->string('redirect_target')->nullable();
            $table->unsignedInteger('position')->default(0);
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
        Schema::dropIfExists('banners');
    }
};
