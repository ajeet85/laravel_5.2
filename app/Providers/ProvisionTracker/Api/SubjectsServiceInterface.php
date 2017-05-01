<?php

namespace App\Providers\ProvisionTracker\Api;
use App\User;
use App\Models\Account;

interface SubjectsServiceInterface{
	public function create_subjects( $wonde_id=null, $org_id, $code, $name );
	public function getSubject( $org_id, $id=null, $pt_id=null, $wonde_id=null );
	public function getSubjects( $org_id );
	public function getSubjectsAsOptions( $org_id );
}