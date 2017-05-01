<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionPhysicalResource extends Model
{
    //
    protected $table = 'provision_physical_resources';
    protected $fillable = array('provision_id', 'physical_resource_id');
}
