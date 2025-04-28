<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlightSegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence',
        'flight_id',
        'airport_id',
        'time',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    public function airport(): BelongsTo
    {
        return $this->belongsTo(Airport::class);
    }

    public function getFormattedTimeAttribute()
    {
        return $this->time->format('H:i');
    }

    public function getFormattedDateAttribute()
    {
        return $this->time->format('d M Y');
    }
}
