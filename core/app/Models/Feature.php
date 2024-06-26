<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use GlobalStatus;

    protected $guarded = ['id'];

    public function hyips(){

        return $this->belongsToMany(Hyip::class,'hyip_features')->withTimestamps();
    }
}
