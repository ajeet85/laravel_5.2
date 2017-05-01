<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionTime extends Model
{
    protected $table = 'provision_times';
    protected $fillable = array('provision_id','time_id');
}
