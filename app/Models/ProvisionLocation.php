<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionLocation extends Model
{
    //
    protected $table = 'provision_locations';
    protected $fillable = array('provision_id', 'location_id');
}
