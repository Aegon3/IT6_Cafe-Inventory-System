<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stocks', function (Blueprint $table) {
            $table->string('stock_ID', 50)->primary();
            $table->string('product_ID', 50);
            $table->integer('quantity')->default(0);
            $table->timestamps();

            $table->foreign('product_ID')->references('product_ID')->on('products')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('stocks');
    }
};
