<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    protected $fillable = ['code', 'name', 'logo'];

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
