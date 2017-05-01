<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'students';
    protected $fillable = array('pt_id','student_id','organisation_id','first_name','last_name','gender','date_of_birth','description');
}
