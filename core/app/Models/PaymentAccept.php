<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAccept extends Model
{
    protected $guarded = ['id'];

    public function hyips(){

        return $this->belongsToMany(Hyip::class,'hyip_payment_accepts')->withTimestamps();
    }
}
