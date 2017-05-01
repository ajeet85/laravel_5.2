<?php
ini_set('max_execution_time', 300); //5 minutes
namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers\Mis\WondeServiceInterface; 
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\ClassServiceInterface;
use App\Providers\ProvisionTracker\Api\StudentServiceInterface;
use App\Providers\ProvisionTracker\Api\TeacherServiceInterface;
use App\Providers\ProvisionTracker\Api\YearGroupServiceInterface;
use App\Providers\ProvisionTracker\Api\SubjectsServiceInterface;

use App\Models\Subjects;

use DB;

class WondeController extends Controller
{
    //

    public function __construct( WondeServiceInterface $wondeService,
    							OrganisationServiceInterface $orgService,
    							ClassServiceInterface $classService,
    							StudentServiceInterface $studentService,
    							TeacherServiceInterface $staffService,
    							YearGroupServiceInterface $yearGroupService,
    							SubjectsServiceInterface $subjectService)
    					 {
        $this->wondeService = $wondeService;
        $this->orgService = $orgService;
        $this->classService = $classService;
        $this->studentService = $studentService;
        $this->staffService = $staffService;
        $this->yearGroupService = $yearGroupService;
        $this->subjectService = $subjectService;
    }
    //--------------------------------------------------------
	/**
     * [importSchoolMisData description]
     * @param  [type] Request        [description]
     * @return [type]                [description]
     */
   

    //--------------------------------------------------------
	public function importSchoolMisData(Request $request){
        $page = $request->input('page', 1);
        $data = [];
        $org_slug = \Request::segment(3);
        $organisation = $this->orgService->getOrganisation(null, $org_slug);
        $org_id = $organisation->id;
        $key = 'A1930499544';
        $this->importYearGroups( $key,$org_id );
        $this->importEmployees( $key,$org_id );
        $this->importStudents( $key,$org_id );
        $this->importSubjects( $key,$org_id );
        $this->importClasses( $key,$org_id );

    }   
    //---------------------------------------------------
	/**
     * [importStudents description]
     * @param  [type] $key       [description]
     * @param  [type] $org_id    [description]
     * @return [type]            [description]
     */
 	public function importStudents( $key,$org_id ){
       $students = $this->wondeService->getStudents($key);
       foreach($students as $student){
        	foreach($student->groups->data as $student_year_groups){
        		
        		$student_year_group = array();
        		$year_group = $this->yearGroupService->getYearGroup(null,null,$student_year_groups->id);
        		
        		$student_year_group[] = $year_group->id;
        	
        	}
        	$create_student = $this->studentService->createStudent($org_id,$student->forename,$student->surname,$student->upi,$student->date_of_birth->date,$student->gender,'',$student->initials,$student->middle_names,$student->id,$student->legal_surname,$student->legal_forename,$student_year_group);
    	}
    	return $create_student;
    }

   	//---------------------------------------------------
	/**
     * [importGroups description]
     * @param  [type] $key       [description]
     * @param  [type] $org_id    [description]
     * @return [type]            [description]
     */
    //----------------------------------------------------

    public function importYearGroups(  $key,$org_id  ){
    	$groups = $this->wondeService->getYearGroups($key);
    	foreach( $groups as $group ){
        	$creat_group = $this->yearGroupService->createYearGroup($org_id,$group->id,$group->name,$group->code,$group->type,$group->description,$group->description);
        }
    }
    //---------------------------------------------------
	/**
     * [importEmployees description]
     * @param  [type] $key       [description]
     * @param  [type] $org_id    [description]
     * @return [type]            [description]
     */
    //----------------------------------------------------
    public function importEmployees( $key,$org_id ){
    	$employees = $this->wondeService->getEmployees($key);
    	 foreach($employees as $employee){

        	$staff['first_name'] = $employee->forename;
        	$staff['last_name'] = $employee->surname;
        	$staff['slug'] = str_slug($staff['first_name'].' '.$staff['last_name'], '-');
        	$staff['provider'] = 'yes';
        	$staff['organisation_id'] = $org_id;
        	$staff['wonde_id'] = $employee->id;
        	$create_staff = $this->staffService->createStaff($staff);

        	$staff_id = $create_staff->id;
        	foreach( $employee->groups->data as $employee_year_group ){

        		
        		$year_group = $this->yearGroupService->getYearGroup(null,null,$employee_year_group->id);
        		
        		$year_group_id = $year_group->id;
        		$this->staffService->staffYearGroup($staff_id,$year_group_id);
        	}
        }

    }
    //---------------------------------------------------
	/**
     * [importClasses description]
     * @param  [type] $key       [description]
     * @param  [type] $org_id    [description]
     * @return [type]            [description]
     */
    //----------------------------------------------------
    public function importClasses( $key,$org_id ){
    	$classes = $this->wondeService->getClasses( $key );
    	foreach( $classes as $class ){
			$students = array();
			$class_staff = array();
			$subject = $this->subjectService->getSubject(  $org_id, $id=null, $pt_id=null, $class->subject->data->id );
			$subject_id = $subject->id;
			foreach($class->students->data as $class_student){
				$student = $this->studentService->getStudent( $org_id, null, null, null,$class_student->id  );
				$students[] = $student->id;
			}
			foreach($class->employees->data as $employees){
				$staff = $this->staffService->getStaffDetails(null,$employees->id);
				$class_staff[] = $staff->id;
			}
			if($subject_id){
				$class = $this->classService->createClass( $class->name, 0, $org_id, $subject_id, $class->id, $students,$class_staff );
			}
			/*else{
				$subject_id = $$this->subjectService->create_subjects( $class->subject->id, $org_id, $class->subject->code, $class->subject->name );
				$class = $this->classService->createClass( $class_name, $class_academic_year, $org_id, $subject_id, $wonde_id, $students,$class_staff );
			}
*/
		}
    }
    //---------------------------------------------------
	/**
     * [importSubjects description]
     * @param  [type] $key       [description]
     * @param  [type] $org_id    [description]
     * @return [type]            [description]
     */
    //----------------------------------------------------
    public function importSubjects(  $key,$org_id  ){
    	$subjects = $this->wondeService->getSubjects( $key );
    	foreach( $subjects as $subject ){
			$create_subject = $this->subjectService->create_subjects( $subject->id, $org_id, $subject->code, $subject->name );
		}
    	
    }

}