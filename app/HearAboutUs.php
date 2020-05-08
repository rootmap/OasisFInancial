<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HearAboutUs extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='hear_about_uses';
}
        