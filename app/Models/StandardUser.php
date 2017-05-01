<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class StandardUser extends User
{
    protected $table = 'users';
}
