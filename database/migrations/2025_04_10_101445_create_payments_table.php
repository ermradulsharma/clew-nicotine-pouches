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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');
            $table->string('status'); // 'pending', 'successful', 'failed'
            $table->string('payment_method')->default('authorize_net');
            $table->string('transaction_id')->nullable(); // From Authorize.Net
            $table->string('authorization_code')->nullable();
            $table->string('response_code')->nullable(); // e.g. 1, 2, 3 (from Authorize.Net)
            $table->text('response_message')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
