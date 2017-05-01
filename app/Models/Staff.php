<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
	protected $table = 'staff';
	protected $fillable = array('organisation_id','first_name', 'last_name','description','provider','cost','slug','pt_id','wonde_id');
}
