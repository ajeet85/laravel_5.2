<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Models\Subjects;
use DB;

Class SubjectsService implements SubjectsServiceInterface{

	public function __construct( UniqueIdServiceInterface $idService ){
		 $this->idService = $idService;
		 
	}

	 public function create_subjects( $wonde_id=null, $org_id, $code, $name ){
		$subject = New Subjects;
		$subject->pt_id = $this->idService->ptId();
		$subject->organisation_id = $org_id;
		$subject->code = $code;
		$subject->name = $name;
		if($wonde_id){
			$subject->wonde_id = $wonde_id;
		}
		$save = $subject->save();
		return $save;
	}
	public function getSubject( $org_id, $id=null, $pt_id=null, $wonde_id=null ){
		$query = [];
		$query['organisation_id'] = $org_id;
		if($id){
			$query['id'] = $id;
		}
		if($pt_id){
			$query['pt_id'] = $pt_id;
		}
		if($wonde_id){
			$query['wonde_id'] = $wonde_id;
		}
		$subject = Subjects::where($query)->first();
		return $subject;
	}

	public function getSubjects( $org_id ){
		return Subjects::where('organisation_id',$org_id)->get();
	}

	public function getSubjectsAsOptions( $org_id ){
		$subjects = $this->getSubjects( $org_id );
        $options = [];
        foreach ($subjects as $subject ) {
            $option = new \stdClass();
            $option->value = $subject->id;
            $option->name = $subject->name;
            $options[] = $option;
        }
        return $options;
	}
}