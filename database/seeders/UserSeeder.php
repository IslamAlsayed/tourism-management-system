<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RichText;
use App\Models\Timezone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        RichText::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // Create users with hardcoded photos
        // PhotoObserver will automatically create MediaFile records
        User::factory()->create([
            'name' => 'tawfiq',
            'email' => 'tawfiq@example.com',
            'bio' => 'Administrator account',
            'first_name' => 'tawfiq',
            'last_name' => 'makhamreh',
            'phone' => '+962 7 9811 4879',
            'mobile' => '+962 7 9811 4879',
            'address' => 'في الأردن أعلى الجبال',
            'birth_date' => '1984-04-12',
            'hire_date' => '2025-09-20',
            'department' => 'Administration',
            'position' => 'HR Manager',
            'is_admin' => 1,
            'timezone_id' => 2,
            'photo' => 'uploads/users/1/Ak5G29KHP54dNf7PG7syIhE8YUck4yRRPAyJbrNS.png',
        ]);

        User::factory()->create([
            'name' => 'islam',
            'email' => 'islam@example.com',
            'bio' => 'developer account',
            'first_name' => 'islam',
            'last_name' => 'alsayed',
            'phone' => '+201065438133',
            'mobile' => '+201065438133',
            'address' => 'في مصر على النيل',
            'birth_date' => '1999-04-29',
            'hire_date' => '2025-09-20',
            'department' => 'Development',
            'position' => 'Senior Developer',
            'is_admin' => 1,
            'timezone_id' => 1,
            'photo' => 'uploads/users/2/2W7uER2vMWn6Eeec8NJgGgYfoYw1eSrV64ZfyM7FC96.png',
        ]);

        User::factory()->create([
            'name' => 'ahmed',
            'email' => 'ahmed@example.com',
            'bio' => 'normal user account',
            'first_name' => 'ahmed',
            'last_name' => 'ali',
            'address' => 'القاهرة، مصر',
            'department' => 'Users',
            'position' => 'User',
            'timezone_id' => 3,
            'photo' => 'uploads/users/3/fhjdy2WvMWn6E8NJgGgYfoYw1eSrV64ZfyM7FC96.png',
        ]);
    }
}