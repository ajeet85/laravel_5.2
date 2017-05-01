<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Models\Staff;
use App\Models\StaffYearGroups;

class TeacherService implements TeacherServiceInterface
{

    public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
    }
	/**
     * [createStaff description]
     * @param  [array] $staff    [contains staff details firstname,lastname,cost,description]
     * @return [type]             [description]
     */
    public function createStaff($staff){
        $staff['pt_id'] = $this->idService->ptId();

    	$insert_staff = Staff::create($staff);
    	return $insert_staff;
    }
     /**
     * [Function to get all Staff Based on organisation]
     * @param  [type] $organisation_id [organisation id value to get all staff based on it]
     * @return [type]             [description]
     */
    public function getStaff( $organisation_id=null, $provider=null){
        $query = [];
        if($organisation_id){
            $query[] = ['organisation_id',$organisation_id];
        }
        else{
            $query[] = ['provider',$provider];
        }
    	$staff_details = Staff::where($query)->get();
        
        return new Collection($staff_details);
    }

    /**
     * [getStaffAsOptions description]
     * @param  [type] $organisation_id [description]
     * @return [type]                  [description]
     */
    public function getStaffAsOptions($organisation_id=null, $provider=null) {
        $staff_members = $this->getStaff($organisation_id,$provider);
        $options = [];
        foreach ($staff_members as $staff_member ) {
            $option = new \stdClass();
            $option->value = $staff_member->id;
            $option->name = "$staff_member->first_name $staff_member->last_name";
            $options[] = $option;
        }
        return $options;
    }

    /**
     * [Function to get Staff Details Based on Staff unique Id]
     * @param  [type] $staff_pt_id [ id value to get all staff based on it]
     * @return [type]             [description]
     */
    public function getStaffDetails($staff_pt_id=null,$wonde_id=null){
        $query = [];
        if($staff_pt_id){
            $query['pt_id'] = $staff_pt_id;
        }
        if($wonde_id){
            $query['wonde_id'] = $wonde_id;
        }

        return Staff::where($query)->first();
    }
    /**
     * [Function to Update Staff Details Based on Staff Unique Id]
     * @param  [type] $staff [ array containing staff details for example first_name,last_name,cost,pt_id]
     * @return [type]             [description]
     */
    public function updateStaffDetails($staff){
        $affectedRows = Staff::where('pt_id', '=', $staff['pt_id'])->update($staff);
        return $affectedRows;
    }
     /**
     * [Function to Delete Staff Details Based on Staff Unique Id]
     * @param  [type] $staff_pt_id [Unique id value to delete staff based on it]
     * @return [type]             [description]
     */
    public function removeStaff($staff_pt_id){
        $query = [];
        $query[] = ['pt_id', $staff_pt_id];
        return Staff::where($query)->delete();
    }

    public function staffYearGroup($staff_id,$year_group_id){
        $pt_id = $this->idService->ptId();
        $staff_year_groups = New StaffYearGroups;
        $staff_year_groups->pt_id = $pt_id;
        $staff_year_groups->staff_id = $staff_id;
        $staff_year_groups->year_group_id = $year_group_id;
        $save = $staff_year_groups->save();
        return $save;
    }
}
