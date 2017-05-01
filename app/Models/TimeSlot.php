<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = array('pt_id',
                                'name',
                                'organisation_id',
                                'start_date',
                                'end_date',
                                'start_time',
                                'end_time',
                                'monday',
                                'tuesday',
                                'wednesday',
                                'thursday',
                                'friday',
                                'saturday',
                                'sunday',
                                'daily',
                                'weekly',
                                'termly',
                                'monthly',
                                'yearly',
                                'repeating');
}
