<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HyipReport extends Model
{
    public function hyip()
    {
        return $this->belongsTo(Hyip::class);
    }
}
