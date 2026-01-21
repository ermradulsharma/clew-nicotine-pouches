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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
            $table->string('coupon_code')->nullable();
            $table->decimal('coupon_discount', 10, 2)->nullable();
            $table->decimal('coupon_amount', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_total', 10, 2)->nullable();
            $table->decimal('grand_total', 10, 2);
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('country')->nullable();
            $table->string('state');
            $table->string('city');
            $table->integer('pincode');
            $table->string('apartment');
            $table->mediumText('address');
            $table->string('billing_name')->nullable();
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->tinyText('billing_address')->nullable();
            $table->string('billing_apartment')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_city')->nullable();
            $table->integer('billing_pincode')->nullable();
            $table->string('billing_mobile')->nullable();
            $table->longText('remark')->nullable();
            $table->string('order_status')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('docket_link')->nullable();
            $table->string('docket_number')->nullable();
            $table->string('pg_id')->nullable();
            $table->string('pg_amount')->nullable();
            $table->string('pg_status')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('created_by')->default(0);
            $table->unsignedTinyInteger('updated_by')->default(0);
            $table->timestamps();
            $table->string('transaction_id')->nullable();
            $table->decimal('total_paid', 10, 2)->nullable();
            $table->timestamp('payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
