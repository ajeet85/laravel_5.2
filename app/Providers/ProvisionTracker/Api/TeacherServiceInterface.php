<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Teacher;

interface TeacherServiceInterface
{
	public function createStaff($staff);
	public function getStaff( $organisation_id=null, $provider=null);
    public function getStaffAsOptions( $organisation_id=null,$provider=null );
	public function getStaffDetails($staff_id=null,$wonde_id=null);
	public function updateStaffDetails($staff);
	public function removeStaff($staff_pt_id);
}
