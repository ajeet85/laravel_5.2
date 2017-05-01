<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = array('pt_id', 'name', 'slug', 'usage', 'organisation_id', 'start_date', 'end_date');
}
