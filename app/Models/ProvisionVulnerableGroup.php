<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionVulnerableGroup extends Model
{
    //
	protected $table = 'provision_vulnerable_groups';
	protected $fillable = array('provision_id','group_id');
}
