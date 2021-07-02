<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripDestination extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "trip_destinations";

    /**
     * @return BelongsTo
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
