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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile');
            $table->date('dob')->nullable();
            $table->string('age_status')->nullable();
            $table->string('age_uuid')->nullable();
            $table->text('age_checker_res')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('country')->nullable();
            $table->bigInteger('state_id')->nullable();
            $table->string('state');
            $table->string('city');
            $table->integer('pincode');
            $table->string('apartment');
            $table->mediumText('address');
            $table->tinyInteger('samebilling')->default(1);
            $table->string('billing_name');
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->tinyText('billing_address');
            $table->string('billing_apartment');
            $table->integer('billing_country_id');
            $table->string('billing_country');
            $table->bigInteger('billing_state_id');
            $table->string('billing_state');
            $table->string('billing_city');
            $table->integer('billing_pincode');
            $table->string('billing_mobile');
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_price', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
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
        Schema::dropIfExists('checkouts');
    }
};
