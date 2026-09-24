<?php

namespace App\Console\Commands;

use App\Models\PG;
use App\Models\PGImage;
use Illuminate\Console\Command;

class SeedLocalPGImages extends Command
{
    protected $signature = 'pg:seed-images';

    protected $description = 'Seed local public PG images for all default PGs';

    public function handle(): int
    {
        $base = public_path('images/pgs');

        if (! is_dir($base)) {
            mkdir($base, 0777, true);
        }

        $slugMap = [
            'StayEase Premium PG' => 'stayease-premium-pg.svg',
            'StayEase Student House' => 'stayease-student-house.svg',
            'StayEase Executive Stay' => 'stayease-executive-stay.svg',
            'StayEase Cozy Rooms' => 'stayease-cozy-rooms.svg',
            'StayEase Ladies Hostel' => 'stayease-ladies-hostel.svg',
            'StayEase Boys Hostel' => 'stayease-boys-hostel.svg',
        ];

        foreach (PG::all() as $pg) {
            $file = $slugMap[$pg->name] ?? 'stayease-ladies-hostel.svg';
            $path = 'images/pgs/'.$file;

            PGImage::updateOrCreate(
                ['pg_id' => $pg->id, 'is_primary' => true],
                ['image' => $path]
            );
        }

        $this->info('PG images seeded locally.');

        return self::SUCCESS;
    }
}
