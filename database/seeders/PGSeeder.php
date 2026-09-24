<?php

namespace Database\Seeders;

use App\Models\PG;
use App\Models\PGImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PGSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pgs = [
            [
                'name' => 'StayEase Premium PG',
                'description' => 'A premium PG offering luxurious accommodation with modern amenities. Perfect for working professionals and students.',
                'address' => 'Near Thaltej, Ahmedabad',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380054',
                'gender' => 'male',
                'monthly_rent' => 8500,
                'security_deposit' => 20000,
                'food_available' => true,
                'status' => 'active',
            ],
            [
                'name' => 'StayEase Student House',
                'description' => 'Affordable and friendly PG for students. Located in the educational hub with easy access to colleges.',
                'address' => 'Navrangpura, Ahmedabad',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380009',
                'gender' => 'female',
                'monthly_rent' => 6500,
                'security_deposit' => 15000,
                'food_available' => true,
                'status' => 'active',
            ],
            [
                'name' => 'StayEase Executive Stay',
                'description' => 'Premium accommodation for busy professionals. Well-equipped with all modern conveniences.',
                'address' => 'Satellite, Ahmedabad',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
                'gender' => 'any',
                'monthly_rent' => 12000,
                'security_deposit' => 30000,
                'food_available' => true,
                'status' => 'active',
            ],
            [
                'name' => 'StayEase Cozy Rooms',
                'description' => 'Comfortable rooms for rent with all basic amenities. Perfect for singles and working couples.',
                'address' => 'Vastrapur, Ahmedabad',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380006',
                'gender' => 'any',
                'monthly_rent' => 7500,
                'security_deposit' => 18000,
                'food_available' => false,
                'status' => 'active',
            ],
            [
                'name' => 'StayEase Ladies Hostel',
                'description' => 'Safe and secure hostel exclusively for women. Provide homely environment with caring management.',
                'address' => 'Mithakhali Six Roads, Ahmedabad',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380006',
                'gender' => 'female',
                'monthly_rent' => 5500,
                'security_deposit' => 12000,
                'food_available' => true,
                'status' => 'active',
            ],
            [
                'name' => 'StayEase Boys Hostel',
                'description' => 'Spacious rooms for boys with excellent amenities. Located near IT parks and corporate offices.',
                'address' => 'Vesu, Surat',
                'city' => 'Surat',
                'state' => 'Gujarat',
                'pincode' => '395007',
                'gender' => 'male',
                'monthly_rent' => 6000,
                'security_deposit' => 14000,
                'food_available' => true,
                'status' => 'active',
            ],
        ];

        $galleryImages = [
            'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200&q=80',
            'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1200&q=80',
            'https://images.unsplash.com/photo-1560185127-6ed189bf02f4?w=1200&q=80',
            'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=1200&q=80',
            'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1200&q=80',
            'https://images.unsplash.com/photo-1560185007-c5ca9d684c08?w=1200&q=80',
        ];

        foreach ($pgs as $index => $pg) {
            $pgModel = PG::firstOrCreate(
                ['name' => $pg['name']],
                array_merge($pg, ['slug' => Str::slug($pg['name'])])
            );

            PGImage::firstOrCreate(
                ['pg_id' => $pgModel->id],
                [
                    'image' => $galleryImages[$index % count($galleryImages)],
                    'is_primary' => true,
                ]
            );
        }
    }
}
