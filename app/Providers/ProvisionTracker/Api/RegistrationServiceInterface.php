<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Package;

interface RegistrationServiceInterface
{
    // create placeholders for account and super user
    // fill in placeholders with real data
    // validate and submit
    // wait for confirmation
    public function getRegistrationAssets( Package $package );
    public function submit( $registration );
    public function confirmRegistration( $confirmation_code );
    public function createAccountname();
}
