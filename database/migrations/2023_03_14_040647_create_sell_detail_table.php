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
        Schema::create('sell_detail', function (Blueprint $table) {
            $table->increments('id_sell_detail');
            $table->integer('id_sell');
            $table->integer('id_product');
            $table->integer('sell_price');
            $table->integer('total');
            $table->tinyInteger('discount')->default(0);
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_detail');
    }
};
