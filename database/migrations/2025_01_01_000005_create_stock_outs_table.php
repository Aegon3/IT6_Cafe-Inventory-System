<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->string('stockout_ID', 50)->primary();
            $table->date('date_issuance');
            $table->string('employee_ID', 50);
            $table->timestamps();

            $table->foreign('employee_ID')->references('employee_ID')->on('employees');
        });

        Schema::create('stock_out_details', function (Blueprint $table) {
            $table->string('stockout_details_ID', 50)->primary();
            $table->string('stockout_ID', 50);
            $table->string('product_ID', 50);
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('stockout_ID')->references('stockout_ID')->on('stock_outs')->onDelete('cascade');
            $table->foreign('product_ID')->references('product_ID')->on('products');
        });
    }
    public function down(): void {
        Schema::dropIfExists('stock_out_details');
        Schema::dropIfExists('stock_outs');
    }
};
