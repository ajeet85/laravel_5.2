<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionsAreaOfNeed extends Model
{
    //
    protected $table = 'provision_areas_of_need';
    protected $fillable = array('provision_id','area_of_need_id');
}
