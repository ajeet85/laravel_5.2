<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsAddress extends Model
{
    //
    protected $table = 'students_address';
    protected $fillable = array('student_id','address_type','house_number','apartment','street','district','town','country','county','postcode','pt_id');
}
