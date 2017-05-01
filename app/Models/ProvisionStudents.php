<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionStudents extends Model
{
    //
    protected $table = 'provision_students';
    protected $fillable = array('provision_id','student_id');
}
