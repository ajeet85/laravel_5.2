<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Models\Klass;
use App\Models\ClassStudentRelationship;
use App\Models\ClassStaffRelationship;
use Illuminate\Pagination\Paginator;
use DB;
class ClassService implements ClassServiceInterface
{
	public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
        $this->max_no_of_records_per_page = 15;
    }

    public function getClasses($org_id){
        $classes = DB::table('classes')
                    ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
                    ->leftJoin('classes_staff','classes_staff.class_id', '=','classes.id')
                    ->leftJoin('staff','staff.id', '=', 'classes_staff.staff_id')
                    ->select('classes.*', 
                        DB::raw("(GROUP_CONCAT(CONCAT(staff.first_name, ' ', staff.last_name) SEPARATOR ',')) as `staff_name`"),'subjects.name as subject_name' 
                        )
                    ->groupBy('classes.id')
                    ->get();
        return new Collection($classes);
    }

    public function createClass( $class_name, $class_academic_year, $organisation_id, $subject_id, $wonde_id=null, $students, $staff ){

        $pt_id = $this->idService->ptId();
        $klass = new Klass;
        $klass->pt_id = $pt_id;
        $klass->class_name = $class_name;
        $klass->academic_year = $class_academic_year;
        $klass->organisation_id = $organisation_id;
        $klass->slug = $slug = str_slug($class_name,'-');;
        $klass->subject_id = $subject_id;
        if($wonde_id){
            $klass->wonde_id = $wonde_id;    
        }
        $created = $klass->save();
        $this->addStudentsToClass( $klass->id, $organisation_id, $students );
        $this->addStaffToClass( $klass->id, $organisation_id, $staff );
        return $created;
    }

    public function getClass($class_pt_id=null, $class_id=null){
        $query = [];
        if($class_pt_id) {
            $query[] = ['pt_id', $class_pt_id];
        }

        if($class_id) {
            $query[] = ['id', $class_id];
        }

        return Klass::where($query)->first();
    }
    public function getClassStaff( $class_id ){
        return ClassStaffRelationship::where('class_id',$class_id)->get();
    }
    public function updateClass( $class_id, $organisation_id, $academic_year, $class_name, $subject_id, $students,$staff){
        $data = [];
        $data['organisation_id'] = $organisation_id;
        $data['academic_year'] = $academic_year;
        $data['class_name'] = $class_name;
        $data['slug'] = str_slug($class_name,'-');
        $data['subject_id'] = $subject_id;
        $affectedRows = Klass::where('id','=',$class_id)->update($data);
        // Update the student list by deleting all first, then re-adding
        $this->removeStudentsFromClass( $class_id, $organisation_id );
        $this->removeStaffFromClass( $class_id, $organisation_id );
        $this->addStudentsToClass( $class_id, $organisation_id, $students );
        $this->addStaffToClass( $class_id, $organisation_id, $staff );
        return $affectedRows;
	}

	public function removeClass($class_pt_id){
		$deleted = Klass::where('pt_id','=',$class_pt_id)->delete();
		return $deleted;
	}

    /**
     * [getStudentsFromClass description]
     * @param  [type] $class_id        [description]
     * @param  [type] $organisation_id [description]
     * @return [type]                  [description]
     */
    public function getStudentsFromClass( $class_id, $organisation_id, &$students) {
        $query = [];
        $query[] = ['class_id', $class_id];
        $query[] = ['organisation_id', $organisation_id];
        $class_students = ClassStudentRelationship::where($query)->get();
        foreach( $students as $student ) {
            $student_in_class = $class_students->where('student_id', $student->id)->first();
            if( $student_in_class ) {
                if($student->id == $student_in_class->student_id){
                    $student->in_class = 'yes';
                }
            }
        }
        return $students;
    }

    /**
     * [addStudentsToClass description]
     * @param [type] $class_id        [description]
     * @param [type] $organisation_id [description]
     * @param [type] $students        [description]
     */
    private function addStudentsToClass( $class_id, $organisation_id, $students ) {

        foreach( $students as $student ) {
            $entry = new ClassStudentRelationship();
            $entry->class_id = $class_id;
            $entry->student_id = $student;
            $entry->organisation_id = $organisation_id;
            $entry->save();
        }
    }

     /**
     * [addStaffToClass description]
     * @param [type] $class_id        [description]
     * @param [type] $organisation_id [description]
     * @param [type] $staff        [description]
     */
    private function addStaffToClass( $class_id, $organisation_id, $staff ) {
        foreach( $staff as $class_staff ) {
            $entry = new ClassStaffRelationship();
            $entry->class_id = $class_id;
            $entry->staff_id = $class_staff;
            $entry->organisation_id = $organisation_id;
            $entry->save();
        }
    }

    /**
     * [removeStudentsFromClass description]
     * @param  [type] $class_id        [description]
     * @param  [type] $organisation_id [description]
     * @return [type]                  [description]
     */
    private function removeStudentsFromClass( $class_id, $organisation_id ) {
        $query = [];
        $query[] = ['class_id', $class_id];
        $query[] = ['organisation_id', $organisation_id];
        ClassStudentRelationship::where($query)->delete();
    }
     /**
     * [removeStaffFromClass description]
     * @param  [type] $class_id        [description]
     * @param  [type] $organisation_id [description]
     * @return [type]                  [description]
     */
    private function removeStaffFromClass( $class_id, $organisation_id ) {
        $query = [];
        $query[] = ['class_id', $class_id];
        $query[] = ['organisation_id', $organisation_id];
        ClassStaffRelationship::where($query)->delete();
    }
}
