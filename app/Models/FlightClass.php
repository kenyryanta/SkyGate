<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightClass extends Model
{
    protected $fillable = ['flight_id', 'class_type', 'price', 'total_seats'];
      protected $casts = [
        'class_type' => 'string',
        'price' => 'integer',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

   public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'flight_class_facilities', 'flight_class_id', 'facility_id');
    }

    //flight_class_facilities transaction_flight_class
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_flight_class');
    }

    public function flightClassFacilities()
    {
        return $this->hasMany(FlightClassFacility::class, 'flight_class_id');
    }
  public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
