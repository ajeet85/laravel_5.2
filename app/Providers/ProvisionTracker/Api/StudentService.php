<?php

namespace App\Providers\ProvisionTracker\Api;
use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Models\Student;
use App\Models\StudentsAddress;
use App\Models\StudentYearGroup;
use Illuminate\Pagination\Paginator;

class StudentService implements StudentServiceInterface
{

     public function __construct( UniqueIdServiceInterface $idService ) {
        $this->idService = $idService;
        $this->max_no_of_records_per_page = 15;
    }
    /**
     * [createStudent description]
     * @param  [type] $student_id   [description]
     * @param  [type] $address_type [description]
     * @param  [type] $house_number [description]
     * @param  [type] $apartment    [description]
     * @param  [type] $street       [description]
     * @param  [type] $district     [description]
     * @param  [type] $town         [description]
     * @param  [type] $country      [description]
     * @param  [type] $county       [description]
     * @param  [type] $post_code    [description]   
     * @return [type]               [description]
     */
    public function createStudentAddress($student_id,$address_type,$house_number,$apartment,$street,$district,$town,$country,$county,$post_code){

        $pt_id = $this->idService->ptId();
        $studdent_address = new StudentsAddress;
        $studdent_address->pt_id = $pt_id;
        $studdent_address->student_id = $student_id;
        $studdent_address->address_type = $address_type;
        $studdent_address->house_number = $house_number;
        $studdent_address->apartment = $apartment;
        $studdent_address->street = $street;
        $studdent_address->district = $district;
        $studdent_address->town = $town;
        $studdent_address->country = $country;
        $studdent_address->county = $county;
        $studdent_address->postcode = $post_code;
        $save = $studdent_address->save();
        return $save;
    }

    /*public function createStudentAttendence($student_attendence){
        $pt_id = $this->idService->ptId();
        $student_attendence = new StudentsAttendence;
        $student_attendence->pt_id = $pt_id;
    }*/
    /**
     * [createStudent description]
     * @param  [type] $organisation [description]
     * @return [type]               [description]
     */
    public function createStudent($organisation,$first_name,$last_name,$student_id,$date_of_birth,$gender,$description,$initials=null,$middle_name=null,$wonde_id=null,$legal_surname=null,$legal_forename=null,$year_groups) {
            $pt_id = $this->idService->ptId();
            $student = new Student; 
            $student->pt_id             = $pt_id;
            $student->first_name        = $first_name;
            $student->last_name         = $last_name;
            $student->student_id        = $student_id;
            $student->organisation_id   = $organisation;
            $student->gender            = $gender;
            $student->date_of_birth     = $date_of_birth;
            $student->description       = $description;
            if($initials)
                $student->initials = $initials;
            if($middle_name)
                $student->middle_names = $middle_name;
            if($wonde_id)
                $student->wonde_id = $wonde_id;
            if($legal_surname)
                $student->legal_surname = $legal_surname;
            if($legal_forename)
                $student->legal_forename = $legal_forename;
            $saved_student = $student->save();
            $this->studentYearGroup($student->id,$year_groups);
        return $saved_student;
    }

    /**
     * [getStudents description]
     * @param  [type] $organisation [description]
     * @return [type]               [description]
     */
    public function getStudents($organisation, $get=true) {
        $query = [];
        $query[] = ['organisation_id', $organisation->id];
        // Allow pagination to be added later
        if( !$get ){
            return Student::where($query);
        } else {
            return Student::where($query)->get();
        }

    }

    /**
     * [getStudent description]
     * @param  [type] $organisation [description]
     * @return [type]               [description]
     */
    public function getStudent( $organisation, $pt_id=null, $student_id=null, $slug=null,$wonde_id=null  ) {
        $query = [];
        $query[] = ['organisation_id', $organisation];

        if( $pt_id ) {
            $query[] = ['pt_id', $pt_id];
        }

        if( $student_id ) {
            $query[] = ['student_id', $student_id];
        }

        if( $slug ) {
            $query[] = ['slug', $slug];
        }
        if($wonde_id){
            $query[] = ['wonde_id',$wonde_id];
         }
        return Student::where($query)->get()->first();
    }

    /**
     * [removeStudent description]
     * @param  [type] $organisation [description]
     * @param  [type] $pt_id        [description]
     * @param  [type] $student_id   [description]
     * @param  [type] $slug         [description]
     * @return [type]               [description]
     */
    public function removeStudent( $organisation, $id ) {
        $query = [];
        $query[] = ['id', $id];
        $query[] = ['organisation_id', $organisation->id];
        return Student::where($query)->delete();
    }

    public function studentYearGroup($student_id,$year_groups){
        
        foreach($year_groups as $year_group){
            $pt_id = $this->idService->ptId();
            $student_year_groups = New StudentYearGroup;
            $student_year_groups->pt_id = $pt_id;
            $student_year_groups->student_id = $student_id;
            $student_year_groups->year_group_id = $year_group;
            $student_year_groups->save(); 
        }
        
        
    }
}
