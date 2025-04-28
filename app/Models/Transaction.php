<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code', 'flight_id', 'customer_id', 'flight_class_id', 'customer_id' ,'name', 'email', 'phone',
        'number_of_passengers', 'promo_code_id', 'payment_status',
        'subtotal', 'grandtotal', 'created_at', 'updated_at'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function flightClass()
    {
        return $this->belongsTo(FlightClass::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function transactionPassengers()
    {
        return $this->hasMany(TransactionPassenger::class);
    }
    public function passengers()
    {
        return $this->hasMany(TransactionPassenger::class);
    }


}
