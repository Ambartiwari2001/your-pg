<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class PG extends Model
{
    protected $table = 'pgs';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'city',
        'state',
        'pincode',
        'latitude',
        'longitude',
        'gender',
        'monthly_rent',
        'security_deposit',
        'food_available',
        'status',
    ];

    protected $casts = [
        'food_available' => 'boolean',
        'monthly_rent' => 'decimal:2',
        'security_deposit' => 'decimal:2',
    ];

    protected $appends = ['primary_image_url'];

    public function images(): HasMany
    {
        return $this->hasMany(PGImage::class, 'pg_id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(PGImage::class, 'pg_id')->where('is_primary', true);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->firstWhere('is_primary', true) ?? $this->images->first();

        if ($primary && ! empty($primary->image_url)) {
            return $primary->image_url;
        }

        $staticSlugPath = 'images/pgs/'.Str::slug($this->name).'.jpg';
        if (file_exists(public_path($staticSlugPath))) {
            return asset($staticSlugPath);
        }

        return asset('images/default-pg.jpg');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'pg_id');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'amenity_pg', 'pg_id', 'amenity_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'pg_id');
    }
}
