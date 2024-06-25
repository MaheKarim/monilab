<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = ['id'];

    public function hyips()
    {
        return $this->hasMany(Hyip::class);
    }
}