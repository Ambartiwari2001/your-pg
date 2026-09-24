<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('123456'),
                'role' => 'admin',
                'phone' => '+91 9876543210',
            ]
        );

        // Regular users
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('123456'),
                'role' => 'user',
                'phone' => '+91 9123456789',
            ]
        );
    }
}
