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
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id_product');
            $table->unsignedInteger('id_category');
            $table->string('code_product')->unique();
            $table->string('name_product')->unique();
            $table->string('brand')->nullable();
            $table->integer('buy_price');
            $table->tinyInteger('discount')->default(0);
            $table->integer('sell_price');
            $table->integer('stock');
            $table->string('batch');
            $table->date('expired_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
