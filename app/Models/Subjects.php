<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    //
    protected $table = 'subjects';
    protected $fillable = array('organisation_id','pt_id','name','code','wonde_id');
}
