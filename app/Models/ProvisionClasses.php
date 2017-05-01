<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionClasses extends Model
{
    //

    protected $table = 'provision_classes';
    protected $fillable = array('provision_id','class_id');
}
