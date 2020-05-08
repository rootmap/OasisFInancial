<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NeverSettleForLess extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='never_settle_for_lesses';
}
        