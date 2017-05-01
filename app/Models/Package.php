<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function packageGroups() {
        $this->belongsTo('App\Models\PackageGroup');
    }
}
