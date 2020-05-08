<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HowWeHelp extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='how_we_helps';
}
        