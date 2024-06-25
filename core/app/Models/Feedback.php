<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $guarded = ['id'];

    public function hyip(){

        return $this->belongsTo(Hyip::class);
    }
}
