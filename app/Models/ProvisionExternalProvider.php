<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionExternalProvider extends Model
{
    //
    protected $table = 'provision_external_providers';
    protected $fillable = array('provision_id', 'external_provider_id');
}
