<?php

namespace App\Providers\ProvisionTracker;
use App\User;
use App\Models\Organisation;

interface PermissionsServiceInterface
{
    public function addContext( Organisation $organisation );
    public function getPermissionsFor( User $user, $context );
    public function updatePermissionsFor( User $user, $permisssions, $context );
    public function clearPermissionsForUser( User $user );
    public function getActions();
    public function getAction($id=null, $label=null);
    public function getElements();
}
