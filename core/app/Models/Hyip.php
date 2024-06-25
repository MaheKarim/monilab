<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hyip extends Model
{
    protected $guarded = ['id'];

    public function paymentAccepts()
    {
        return $this->belongsToMany(PaymentAccept::class,'hyip_payment_accepts')->withTimestamps();
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class,'hyip_features')->withTimestamps();
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function feedbacks()
    {
        return $this->hasMany(Type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userPolls()
    {
        return $this->hasMany(UserPoll::class);
    }
}
