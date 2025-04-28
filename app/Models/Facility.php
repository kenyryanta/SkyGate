<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['name', 'image', 'description'];


    public function flightClassFacilities()
    {
        return $this->hasMany(FlightClassFacility::class, 'facility_id');
    }

    public function flights()
    {
        return $this->belongsToMany(Flight::class, 'flight_class_facilities', 'facility_id', 'flight_id');
    }

    public function flightClasses()
    {
        return $this->belongsToMany(FlightClass::class, 'flight_class_facilities', 'facility_id', 'flight_class_id');
    }



}
