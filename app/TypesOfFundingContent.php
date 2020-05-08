<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypesOfFundingContent extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='types_of_funding_contents';
}
        