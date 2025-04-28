<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightSeat extends Model
{

    protected $fillable = ['flight_id', 'row', 'column', 'class_type', 'is_available'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function transactionPassenger()
    {
        return $this->hasOne(TransactionPassenger::class);
    }
}
