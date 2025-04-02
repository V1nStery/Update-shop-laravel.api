<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('city');
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->string('product_name');
        $table->decimal('product_price', 8, 2);
        $table->unsignedBigInteger('product_id');
        $table->string('product_color')->nullable(); // Добавляем цвет
        $table->string('product_memory')->nullable(); // Добавляем память
        $table->text('product_description')->nullable(); // Добавляем описание
        $table->timestamps();
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
