<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SuperUser extends User
{
    protected $table = 'users';
}
