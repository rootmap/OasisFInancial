<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BetterDaysStartToday extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='better_days_start_todaies';
}
        