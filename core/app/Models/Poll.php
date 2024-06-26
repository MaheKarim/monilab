<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use GlobalStatus;
    protected $guarded = ['id'];
}
