<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempHyip extends Model
{
    protected $guarded = ['id'];

    public function paymentAccepts()
    {
        return $this->belongsToMany(PaymentAccept::class,'temp_hyip_payment_accepts')->withTimestamps();
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class,'temp_hyip_features')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
