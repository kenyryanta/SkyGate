<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'airline_id',
    ];

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    public function flightSegments(): HasMany
    {
        return $this->hasMany(FlightSegment::class);
    }

    public function flightClasses(): HasMany
    {
        return $this->hasMany(FlightClass::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'flight_class_facilities', 'flight_id', 'facility_id')->withPivot('flight_class_id')->withPivot('flight_class_id');
    }


    public function seats(): HasMany
    {
        return $this->hasMany(FlightSeat::class);
    }

    public function getDepartureSegment()
    {
        return $this->flightSegments()->where('sequence', 1)->first();
    }

    public function getArrivalSegment()
    {
        return $this->flightSegments()->orderBy('sequence', 'desc')->first();
    }

    public function getTransitSegments()
    {
        return $this->flightSegments()->whereNot('sequence', 1)
            ->whereNot('sequence', function($query) {
                $query->selectRaw('MAX(sequence)')->from('flight_segments')
                    ->where('flight_id', $this->id);
            })->orderBy('sequence')->get();
    }

    public function getTotalDuration()
    {
        $departure = $this->getDepartureSegment();
        $arrival = $this->getArrivalSegment();

        if ($departure && $arrival) {
            return $arrival->time->diffInMinutes($departure->time);
        }

        return 0;
    }
}
