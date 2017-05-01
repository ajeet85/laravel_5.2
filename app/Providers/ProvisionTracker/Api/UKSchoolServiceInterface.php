<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\UKSchool;

interface UKSchoolServiceInterface
{
    public function getSchool( $request=null, $dfe_number=null );
    public function claimSchool( $dfe_number, $pt_id );
    public function unClaimSchool( $dfe_number );
}
