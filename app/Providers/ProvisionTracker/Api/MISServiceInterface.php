<?php

namespace App\Providers\ProvisionTracker\Api;
use Illuminate\Http\Request;

interface MISServiceInterface
{
    public function getProvider($id=null, $name=null, $slug=null);
    public function getMISProviders();
    public function getMISService($id=null);
    public function getMISServices();
    public function updateService( $id, $data );
    public function getSchoolService( $school_id );
}
