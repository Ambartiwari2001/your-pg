<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'pg_id',
        'room_number',
        'room_type',
        'total_beds',
        'available_beds',
        'monthly_rent',
        'status',
    ];

    protected $casts = [
        'monthly_rent' => 'decimal:2',
    ];

    public function pg(): BelongsTo
    {
        return $this->belongsTo(PG::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
