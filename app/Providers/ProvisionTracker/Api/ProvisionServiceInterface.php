<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Provision;

interface ProvisionServiceInterface
{
    public function getProvisions($org_id);
    public function createProvision( $organisation_id, $request);
    public function getProvision($pt_id);
    public function updateProvision( $organisation_id, $request);
    public function removeProvision($pt_id);
    public function getAllocatedAreaOfNeeds($pt_id);
    public function getAllocatedStudents($pt_id);
    public function getAllocatedClasses($pt_id);
    public function getAllocatedStaff($pt_id);
    public function getAllocatedTimes( $provision_id );
    public function getAllocatedDigitalResources( $provision_id );
    public function getAllocatedPhysicalResources( $provision_id );
    public function getAllocatedHumanResources( $provision_id );
    public function getAllocatedLocations( $provision_id );
    public function getAllocatedExternalProviders( $provision_id );
}
