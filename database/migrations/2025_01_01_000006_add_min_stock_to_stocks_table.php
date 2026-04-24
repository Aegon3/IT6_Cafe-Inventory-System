<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('stocks', function (Blueprint $table) {
            $table->integer('min_stock')->default(20)->after('quantity');
        });
    }
    public function down(): void {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn('min_stock');
        });
    }
};
