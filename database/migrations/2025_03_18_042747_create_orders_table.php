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
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->integer('total_order');
            $table->enum('status_order',['pending', 'processing', 'completed','progressing','cancelled'])->default('pending');
            $table->enum('status_payments',['pending', 'completed'])->default('pending');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('method_payment_id')->constrained('method_payments')->onDelete('cascade')->onUpdate('cascade');
            $table->text('paypal_transaction_id')->nullable();
            $table->text('paypal_response')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
