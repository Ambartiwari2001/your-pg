<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            ['name' => 'Wi-Fi', 'icon' => '📶'],
            ['name' => 'Food Available', 'icon' => '🍽️'],
            ['name' => 'AC', 'icon' => '❄️'],
            ['name' => 'Parking', 'icon' => '🚗'],
            ['name' => 'CCTV', 'icon' => '📹'],
            ['name' => 'Washing Machine', 'icon' => '🧺'],
            ['name' => 'Power Backup', 'icon' => '⚡'],
            ['name' => 'Hot Water', 'icon' => '🚿'],
            ['name' => 'Housekeeping', 'icon' => '🧹'],
            ['name' => 'Attached Bathroom', 'icon' => '🚿'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate($amenity);
        }
    }
}
