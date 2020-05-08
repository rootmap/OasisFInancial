<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpCaseTypesData extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='help_case_types_datas';
}
        