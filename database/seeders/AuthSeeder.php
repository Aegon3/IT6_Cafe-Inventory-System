<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account — login: admin@cafedampog.com / admin123
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@cafedampog.com'],
            [
                'name'        => 'Admin',
                'email'       => 'admin@cafedampog.com',
                'password'    => Hash::make('admin123'),
                'is_admin'    => true,
                'employee_ID' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );
    }
}
