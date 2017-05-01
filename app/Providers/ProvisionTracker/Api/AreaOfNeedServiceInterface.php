<?php

namespace App\Providers\ProvisionTracker\Api;
use App\User;
use App\Models\Account;

interface AreaOfNeedServiceInterface{
	public function getAreaOfNeeds($org_id);
	public function createAreaOfNeed($organisation_id,$area_of_need_name,$area_of_need_description,$parent_id);
	public function getAreaOfNeed( $org_id,$pt_id=null,$name=null );
	public function updateAreaOfNeed($pt_id,$org_id,$area_of_need_name,$areaofneed_description);
	public function removeAreaOfNeed( $org_id, $id=null, $pt_id=null );
	public function importDefault( $org_id,$file_path );
	
}