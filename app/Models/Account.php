<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function packages()
    {
        return $this->hasOne('App\Models\Packages');
    }

    public function superUser()
    {
        return $this->hasOne('App\Models\SuperUser');
    }
}
