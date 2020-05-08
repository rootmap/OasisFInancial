<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderContent extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='slider_contents';
}
        