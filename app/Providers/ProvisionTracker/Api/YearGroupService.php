<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Models\YearGroup;

class YearGroupService implements YearGroupServiceInterface
{
	 public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
        
    }
    public function createYearGroup($org_id,$wonde_id=null,$name,$code,$type,$description,$notes){
    	$pt_id = $this->idService->ptId();
    	$year_group = New YearGroup;
    	$year_group->pt_id = $pt_id;
    	$year_group->organisation_id = $org_id;
    	$year_group->name = $name;
    	$year_group->code = $code;
    	$year_group->type = $type;
    	$year_group->description = $description;
    	$year_group->notes = $notes;
    	if($wonde_id)
    		$year_group->wonde_id = $wonde_id;
    	$save = $year_group->save();
    }
    public function getYearGroup($id=null,$pt_id=null,$wonde_id=null){
    	$query=[];
    	
    	if($id){
    		$query['id'] = $id;
    	}
    	if($pt_id){
    		$query['pt_id'] = $pt_id;
    	}
    	if($wonde_id){
    		$query['wonde_id'] = $wonde_id;
    	}
    	return YearGroup::where($query)->first();
    }
}