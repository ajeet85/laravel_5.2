<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Account;

interface ResourceServiceInterface{

	public function getResourceType($id=null, $slug=null);
	public function getResources($org_id, $type_id=null);
	public function getResouceTypeAsOptions();
	public function createResource($resource_name,$resource_cost,$resource_type_id,$organisation_id);
	public function getResource($pt_id);
	public function updateResource($pt_id,$resource_name,$resource_cost,$resource_type_id,$organisation_id);
	public function deleteResource($pt_id);
	public function getAllResources($org_id, $type_id=null);
}

?>
