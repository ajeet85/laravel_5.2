<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionDigitalResource extends Model
{
    //
    protected $table = 'provision_digital_resources';
    protected $fillable = array('provision_id', 'digital_resource_id');
}
