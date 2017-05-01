<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MISSchoolService extends Model
{
    protected $table = 'mis_schools_services';
    protected $fillable = array('username','password', 'school_id','service_id','provider_id', 'organisation_id');
}
