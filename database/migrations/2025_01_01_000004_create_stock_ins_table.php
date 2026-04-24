<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->string('stockin_ID', 50)->primary();
            $table->date('date_added');
            $table->string('employee_ID', 50);
            $table->timestamps();

            $table->foreign('employee_ID')->references('employee_ID')->on('employees');
        });

        Schema::create('stock_in_details', function (Blueprint $table) {
            $table->string('stockin_details_ID', 50)->primary();
            $table->string('stockin_ID', 50);
            $table->string('product_ID', 50);
            $table->integer('quantity');
            $table->decimal('cost_per_unit', 10, 2);
            $table->timestamps();

            $table->foreign('stockin_ID')->references('stockin_ID')->on('stock_ins')->onDelete('cascade');
            $table->foreign('product_ID')->references('product_ID')->on('products');
        });
    }
    public function down(): void {
        Schema::dropIfExists('stock_in_details');
        Schema::dropIfExists('stock_ins');
    }
};
