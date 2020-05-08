<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseType extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='case_types';
}
        