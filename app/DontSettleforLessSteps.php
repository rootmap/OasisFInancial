<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DontSettleforLessSteps extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='dont_settle_for_less_stepses';
}
        