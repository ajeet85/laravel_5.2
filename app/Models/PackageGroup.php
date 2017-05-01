<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageGroup extends Model
{
    public function packages() {
        return $this->hasMany('App\Models\Package');
    }
}
