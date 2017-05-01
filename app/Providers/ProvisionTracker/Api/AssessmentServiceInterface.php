<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\AssessmentType;

interface AssessmentServiceInterface
{
    public function getAssessmentTypes();
    public function getAssessmentType( $id=null, $slug=null, $pt_id=null );
    public function removeAssessmentType( $org_id,$id=null );
    public function updateAssessmentType( $id, $new_assessment_name, $new_grades );
    public function getAssessmentTypeGrades( $assessment_type_id=null, $slug=null, $pt_id=null );
    public function createAssessmentType( $orginal_id, $assessment_name, $grades, $organisation );
    public function copyAssessmentType( $orginal_id, $organisation );
}
