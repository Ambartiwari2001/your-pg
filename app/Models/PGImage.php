<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PGImage extends Model
{
    protected $table = 'pg_images';

    protected $fillable = [
        'pg_id',
        'image',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function pg(): BelongsTo
    {
        return $this->belongsTo(PG::class);
    }

    public function getImageUrlAttribute(): string
    {
        $image = $this->image ?? '';

        if (empty($image)) {
            return asset('images/default-pg.jpg');
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        if (str_starts_with($image, 'images/') || str_starts_with($image, '/images/')) {
            return asset(ltrim($image, '/'));
        }

        if (str_starts_with($image, 'storage/') || str_starts_with($image, '/storage/')) {
            return asset(ltrim($image, '/'));
        }

        return asset('storage/'.ltrim($image, '/'));
    }
}
