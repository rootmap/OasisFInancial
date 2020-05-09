<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StructuredSettlementApplicationForm extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='structured_settlement_application_forms';
}
        