<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = ['code', 'discount_type', 'discount', 'valid_until', 'is_used'];

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
