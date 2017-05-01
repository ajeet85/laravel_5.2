<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Groups;

interface YearGroupServiceInterface
{
 
 public function createYearGroup($org_id,$wonde_id=null,$name,$code,$type,$description,$notes);
 
}
