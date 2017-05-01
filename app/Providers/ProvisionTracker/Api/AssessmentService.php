<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\AssessmentType;
use App\Models\AssessmentTypeGrade;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use Illuminate\Pagination\Paginator;
use DB;
class AssessmentService implements AssessmentServiceInterface
{
    public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
        $this->max_no_of_records_per_page = 15;
    }

    /**
     * [getAssessmentTypes description]
     * @return [type] [description]
     */
    public function getAssessmentTypes() {
        return AssessmentType::paginate($this->max_no_of_records_per_page);
    }

    /**
     * [getAssessmentType description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getAssessmentType( $id=null, $slug=null, $pt_id=null ) {
        $query = [];
        if($id) {
            $query[] = ['id', $id];
        }
        if($slug) {
            $query[] = ['slug', $slug];
        }
        if($pt_id) {
            $query[] = ['pt_id', $pt_id];
        }
        return AssessmentType::where($query)->get()->first();
    }

    /**
     * [removeAssessmentType description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function removeAssessmentType( $org_id,$id=null ) {
        $query = [];
        if( $org_id ){
            $query[] = ['organisation_id',$org_id];
        }
        if( $id ){
            $query[] = ['id', $id];    
        }
        return AssessmentType::where($query)->delete();
    }

    /**
     * [getAssessmentTypeGrades description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getAssessmentTypeGrades( $assessment_type_id=null, $slug=null, $pt_id=null ) {
        $query = [];
        if($assessment_type_id) {
            $query[] = ['assessment_type', $assessment_type_id];
        }
        if($slug) {
            $query[] = ['slug', $slug];
        }
        if($pt_id) {
            $query[] = ['pt_id', $pt_id];
        }

        return AssessmentTypeGrade::where($query)->get();
    }

    /**
     * [updateAssessmentType description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function updateAssessmentType( $id, $new_assessment_name, $new_grades ) {
        // Make the base type
        $assessmentType = $this->getAssessmentType($id);
        $assessmentType->name = $new_assessment_name;
        $assessmentType->slug = str_slug($new_assessment_name, '-');
        $assessmentType->save();
        // Make the grades
        $internal_grade = 0;
        $original_grades = $this->getAssessmentTypeGrades($id);
        foreach( $original_grades as $original_grade ) {
            $assessmentGrade = $original_grade;
            $assessmentGrade->name = $new_assessment_name;
            $assessmentGrade->slug = str_slug($new_assessment_name, '-');
            $assessmentGrade->public_grade = $new_grades[$original_grade->id]['grade'];
            $assessmentGrade->internal_grade = $internal_grade;
            $assessmentGrade->band = $new_grades[$original_grade->id]['band'];
            $assessmentGrade->kpi = $new_grades[$original_grade->id]['kpi'];
            $assessmentGrade->save();
            $internal_grade++;
        }
        return $assessmentType;
    }

    /**
     * [createAssessmentType description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function createAssessmentType( $orginal_id, $new_assessment_name, $new_grades, $organisation ) {
        // Make the base type
        $assessmentType = new AssessmentType();
        $assessmentType->pt_id = $this->idService->ptId();
        $assessmentType->name = $new_assessment_name;
        $assessmentType->slug = str_slug($new_assessment_name, '-');
        $assessmentType->organisation_id = $organisation;
        $assessmentType->save();
        // Make the grades
        $internal_grade = 0;
        $original_grades = $this->getAssessmentTypeGrades($orginal_id);
        foreach( $original_grades as $original_grade ) {
            $assessmentGrade = new AssessmentTypeGrade();
            $assessmentGrade->pt_id = $this->idService->ptId();
            $assessmentGrade->name = $new_assessment_name;
            $assessmentGrade->slug = str_slug($new_assessment_name, '-');
            $assessmentGrade->organisation_id = $organisation;
            $assessmentGrade->assessment_type = $assessmentType->id;
            $assessmentGrade->public_grade = $new_grades[$original_grade->id]['grade'];
            $assessmentGrade->internal_grade = $internal_grade;
            $assessmentGrade->band = $new_grades[$original_grade->id]['band'];
            $assessmentGrade->kpi = $new_grades[$original_grade->id]['kpi'];
            $assessmentGrade->save();
            $internal_grade++;
        }
    }

    /**
     * [copyAssessmentType description]
     * @param  [type] $orginal_id   [description]
     * @param  [type] $organisation [description]
     * @return [type]               [description]
     */
    public function copyAssessmentType( $orginal_id, $organisation ) {
        $orignal_assessment_type = $this->getAssessmentType($orginal_id);
        $original_grades = $this->getAssessmentTypeGrades($orginal_id);

        $copies = \DB::table('assessment_types')
                        ->where('name', 'like', "$orignal_assessment_type->name%")
                        ->get();
        $totalCopies = count($copies);
        $new_name = $orignal_assessment_type->name . " copy " . ($totalCopies + 1);

        $copiedType = new AssessmentType();
        $copiedType->pt_id = $this->idService->ptId();
        $copiedType->name = $new_name;
        $copiedType->slug = str_slug($new_name, '-');
        $copiedType->organisation_id = $organisation;
        $copiedType->save();

        $internal_grade = 0;
        $original_grades = $this->getAssessmentTypeGrades($orginal_id);
        foreach( $original_grades as $original_grade ) {
            $copiedGrade = new AssessmentTypeGrade();
            $copiedGrade->pt_id = $this->idService->ptId();
            $copiedGrade->name = $new_name;
            $copiedGrade->slug = str_slug($new_name, '-');
            $copiedGrade->organisation_id = $organisation;
            $copiedGrade->assessment_type = $copiedType->id;
            $copiedGrade->public_grade = $original_grade->public_grade;
            $copiedGrade->internal_grade = $internal_grade;
            $copiedGrade->band = $original_grade->band;
            $copiedGrade->kpi = $original_grade->kpi;
            $copiedGrade->save();
            $internal_grade++;
        }
    }

    public function getAssesment( $org_id, $pt_id=null, $name=null ){
        $query = [];
        $query['organisation_id'] = $org_id;
        if( $pt_id ){
            $query[] = ['pt_id',$pt_id];
        }
        if( $name ){
            $query[] = ['name',$name];
        }
        return AssessmentType::where($query)->get()->first();
    }

    /**
     * [importDefault description]
     * @param  [type] $org_id [description]
     * @return [type]         [description]
     */
    public function importDefault( $org_id,$file_path ) {
        // Remove all terms first
       
        $idService = $this->idService;
        \Excel::load($file_path, function($reader) use ($idService,$org_id) {
            foreach($reader->get() as $sheet)
            {
                $sheetTitle = $sheet->getTitle();
                $check_ass_type = $this->getAssesment( $org_id,null,$sheetTitle );
                
                if(!$check_ass_type){
                        $id = \DB::table('assessment_types')->insertGetId([
                        'name' => $sheetTitle,
                        'pt_id' => $idService->ptId(),
                        'slug' => str_slug($sheetTitle, '-'),
                        'organisation_id' => $org_id
                    ]);
                }
                else{
                   $id = $check_ass_type->id;
                }

                $sheet->each(function( $row ) use ($sheetTitle, $id, $idService,$org_id) {
                    // \Log::info($row->public_grade);
                    \DB::table('assessment_type_grades')->insert([
                        'pt_id' => $idService->ptId(),
                        'name' => $sheetTitle,
                        'slug' => str_slug($sheetTitle, '-'),
                        'organisation_id' => $org_id,
                        'assessment_type' => $id,
                        'public_grade' => $row->public_grade,
                        'internal_grade' => $row->internal_grade,
                        'band' => $row->band,
                        'kpi' => $row->kpi
                    ]);
                });
            }
        });
        return true;
    }


}
