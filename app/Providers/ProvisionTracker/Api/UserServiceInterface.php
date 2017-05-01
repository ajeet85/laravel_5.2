<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\SuperUser;
use App\User;

interface UserServiceInterface
{
    // get all users
    // get all standard users
    // get all super users
    public function getUsers( $type=null, $account=null );
    public function getUser( $email=null, $id=null, $slug=null );
    public function createUser( $type, $pt_id );
    public function deleteUser( $email );
    // public function register( SuperUser $user );
    // public function validateUser( User $user );
}
