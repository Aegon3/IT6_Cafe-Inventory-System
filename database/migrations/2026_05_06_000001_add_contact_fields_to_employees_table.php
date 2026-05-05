<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('contact_number', 20)->nullable()->after('e_role');
            $table->string('employee_address', 255)->nullable()->after('contact_number');
            $table->string('sss_number', 20)->nullable()->after('employee_address');
            $table->string('philhealth_number', 20)->nullable()->after('sss_number');
        });
    }
    public function down(): void {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['contact_number', 'employee_address', 'sss_number', 'philhealth_number']);
        });
    }
};
