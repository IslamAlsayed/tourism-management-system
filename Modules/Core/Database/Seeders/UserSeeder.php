<?php

namespace Modules\Core\Database\Seeders;

use App\Models\MediaFile;
use App\Models\RichText;
use Illuminate\Database\Seeder;
use Modules\Core\Entities\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        truncateWithReset(User::class);
        truncateWithReset(MediaFile::class);
        RichText::where('record_type', User::class)->delete();
        RichText::where('record_type', MediaFile::class)->delete();

        // Create users with hardcoded photos and assign roles
        // PhotoObserver will automatically create MediaFile records

        // Superadmin User
        $tawfiq = User::factory()->create([
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
            'role' => 'superadmin',
            'timezone_id' => 2,
            'photo' => 'uploads/users/1/Ak5G29KHP54dNf7PG7syIhE8YUck4yRRPAyJbrNS.png',
        ]);
        $tawfiq->assignRole('superadmin');

        // Admin User
        $islam = User::factory()->create([
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
            'role' => 'admin',
            'timezone_id' => 1,
            'photo' => 'uploads/users/2/2W7uER2vMWn6Eeec8NJgGgYfoYw1eSrV64ZfyM7FC96.png',
        ]);
        $islam->assignRole('admin');

        // Regular User
        $ahmed = User::factory()->create([
            'name' => 'ahmed',
            'email' => 'ahmed@example.com',
            'bio' => 'normal user account',
            'first_name' => 'ahmed',
            'last_name' => 'ali',
            'address' => 'القاهرة، مصر',
            'department' => 'Users',
            'position' => 'User',
            'role' => 'user',
            'timezone_id' => 3,
            'photo' => 'uploads/users/3/fhjdy2WvMWn6E8NJgGgYfoYw1eSrV64ZfyM7FC96.png',
        ]);
        $ahmed->assignRole('user');
    }
}
