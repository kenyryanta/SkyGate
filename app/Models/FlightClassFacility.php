<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightClassFacility extends Model
{
    // protected $fillable = ['flight_class_id', 'facility_id'];
    protected $fillable = ['flight_id', 'flight_class_id', 'facility_id'];
    // public function flightclass()
    // {
    //     return $this->belongsToMany(FlightClass::class, 'flight_class_facilities');
    // }
    // // flight_class_facilities flight_class_facility
    // public function facilities()
    // {
    //     return $this->belongsToMany(Facility::class, 'flight_class_facilities');
    // }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function flightClass()
    {
        return $this->belongsTo(FlightClass::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
