<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $guarded = ['id'];

    public function hyips(){

        return $this->belongsToMany(Hyip::class,'hyip_features')->withTimestamps();
    }
}
