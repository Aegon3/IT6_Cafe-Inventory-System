<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employees', function (Blueprint $table) {
            $table->string('employee_ID', 50)->primary();
            $table->string('employee_Fname', 100);
            $table->string('employee_Lname', 100);
            $table->string('e_role', 100);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('employees');
    }
};
