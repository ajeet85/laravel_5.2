<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Klass;

interface ClassServiceInterface
{
    public function getClasses($org_id);
    public function createClass( $class_name, $class_academic_year, $organisation_id, $staff_id, $wonde_id=null, $students, $staff);
    public function getClass($class_pt_id=null, $class_id=null);
    public function getStudentsFromClass( $class_id, $organisation_id, &$students);
    public function updateClass($class_id,$organisation_id,$academic_year,$class_name, $staff, $students,$subject_id);
    public function removeClass($class_pt_id);
}
