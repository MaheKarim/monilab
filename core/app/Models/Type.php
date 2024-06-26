<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use GlobalStatus;
    protected $guarded = ['id'];

    public function hyips()
    {
        return $this->hasMany(Hyip::class);
    }
}
