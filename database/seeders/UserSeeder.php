<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '12345678',
            'bio' => 'Administrator account',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone' => '1234567890',
            'mobile' => '0987654321',
            'address' => '123 Admin St, Admin City, Admin Country',
            'user_code' => 'ADMIN001',
            'employee_id' => 'EMP001',
            'hire_date' => '2020-01-01',
            'department' => 'Administration',
            'position' => 'Administrator',
            'preferred_language' => 'en',
            'timezone' => 'UTC',
            'preferences' => json_encode(['theme' => 'dark']),
            'email_verified_at' => null,
            'is_admin' => true,
            'avatar_url' => null,
            'is_active' => true,
            'is_verified' => true,
            'force_password_change' => false,
            'last_login_at' => null,
            'last_login_ip' => null,
            'notes' => null,
        ]);
    }
}