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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('om_title')->nullable();
            $table->string('om_image')->nullable();
            $table->text('om_description')->nullable();
            $table->string('ov_title')->nullable();
            $table->string('ov_image')->nullable();
            $table->text('ov_description')->nullable();
            $table->string('qa_title')->nullable();
            $table->string('qa_image')->nullable();
            $table->text('qa_description')->nullable();
            $table->string('ni_title')->nullable();
            $table->string('ni_image')->nullable();
            $table->text('ni_description')->nullable();
            $table->string('m_title')->nullable();
            $table->string('m_image')->nullable();
            $table->string('m_video')->nullable();
            $table->text('m_description')->nullable();
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
        Schema::dropIfExists('abouts');
    }
};
