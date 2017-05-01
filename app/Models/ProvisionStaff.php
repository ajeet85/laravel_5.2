<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionStaff extends Model
{
    //
    protected $table = 'provision_staff';
    protected $fillable = array('provision_id','staff_id');
}
