<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'pg_id',
        'room_id',
        'booking_number',
        'move_in_date',
        'duration_months',
        'occupants',
        'monthly_rent',
        'security_deposit',
        'total_amount',
        'status',
        'notes',
        'rejection_note',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pg(): BelongsTo
    {
        return $this->belongsTo(PG::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(BookingDocument::class);
    }
}
