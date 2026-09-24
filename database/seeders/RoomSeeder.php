<?php

namespace Database\Seeders;

use App\Models\PG;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pgs = PG::all();

        foreach ($pgs as $pg) {
            // Create rooms for each PG
            Room::firstOrCreate(
                ['pg_id' => $pg->id, 'room_number' => '101'],
                [
                    'room_type' => 'single',
                    'total_beds' => 1,
                    'available_beds' => 1,
                    'monthly_rent' => $pg->monthly_rent,
                    'status' => 'active',
                ]
            );

            Room::firstOrCreate(
                ['pg_id' => $pg->id, 'room_number' => '102'],
                [
                    'room_type' => 'double',
                    'total_beds' => 2,
                    'available_beds' => 2,
                    'monthly_rent' => $pg->monthly_rent + 2000,
                    'status' => 'active',
                ]
            );

            Room::firstOrCreate(
                ['pg_id' => $pg->id, 'room_number' => '201'],
                [
                    'room_type' => 'triple',
                    'total_beds' => 3,
                    'available_beds' => 2,
                    'monthly_rent' => $pg->monthly_rent + 4000,
                    'status' => 'active',
                ]
            );
        }
    }
}
