<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Student;

interface StudentServiceInterface
{
    public function createStudent($organisation,$first_name,$last_name,$student_id,$date_of_birth,$gender,$description,$initials=null,$middle_name=null,$wonde_id=null,$legal_surname=null,$legal_forename=null,$year_groups);
    public function getStudents($organisation, $get=true);
    public function getStudent($organisation, $pt_id=null, $student_id=null, $slug=null,$wonde_id=null );
    public function removeStudent( $organisation, $id );
}
