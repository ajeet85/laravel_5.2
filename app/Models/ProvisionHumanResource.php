<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionHumanResource extends Model
{
    //
    protected $table = 'provision_human_resources';
    protected $fillable = array('provision_id', 'human_resource_id');
}
