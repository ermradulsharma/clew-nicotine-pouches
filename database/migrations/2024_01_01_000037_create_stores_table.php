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
        Schema::create('stores', function (Blueprint $table) {
            $table->integer('id')->primary(); // SQL has int NOT NULL for id
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->integer('zip');
            $table->string('country');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('filename')->nullable();
            $table->tinyInteger('created_by')->nullable();
            $table->dateTime('created_at');
            $table->tinyInteger('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
