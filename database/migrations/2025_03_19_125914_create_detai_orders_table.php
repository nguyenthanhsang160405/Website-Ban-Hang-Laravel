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
        Schema::create('detai_orders', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('image');
            $table->integer('price');
            $table->integer('quantity');
            $table->string('size');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('cascade');
            $table->boolean('check_comment')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detai_orders');
    }
};
