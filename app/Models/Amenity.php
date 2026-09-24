<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    protected $fillable = [
        'name',
        'icon',
    ];

    public function pgs(): BelongsToMany
    {
        return $this->belongsToMany(PG::class, 'amenity_pg');
    }
}
