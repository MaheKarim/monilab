<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class PaymentAccept extends Model
{
    use GlobalStatus;
    protected $guarded = ['id'];

    public function hyips(){

        return $this->belongsToMany(Hyip::class,'hyip_payment_accepts')->withTimestamps();
    }
}
