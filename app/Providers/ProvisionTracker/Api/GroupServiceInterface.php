<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Groups;

interface GroupServiceInterface
{
 public function getGroups($org_id=null);
 public function createGroup($org_id,$group_name,$group_description,$slug);
 public function getGroup( $org_id,$pt_id=null,$name=null );
 public function updateGroup($pt_id,$org_id,$group_name,$group_description,$slug);
 public function removeGroup($org_id, $id=null, $pt_id=null);
 public function importDefault( $org_id,$file_path );
}
