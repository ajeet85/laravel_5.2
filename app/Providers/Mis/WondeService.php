<?php

namespace App\Providers\Mis;

use Illuminate\Database\Eloquent\Collection;


class WondeService implements WondeServiceInterface
{
    public function __construct(){
        $client = new \Wonde\Client('efe671c968e9198ac99930ba69b5400e453a9081');
        $this->client = $client;
    }

    public function getSchool( $school_id ){
        $school = $this->client->school($school_id);
        return $school;
    }
    
    public function getStudents( $school_id ){
        $school = $this->getSchool( $school_id );
        return $school->students->all(['education_details','contact_details','attendance_summary','extended_details','permissions','photo','groups']);
    }

    public function getEmployees( $school_id ){
        $school = $this->getSchool( $school_id );
        return $school->employees->all(['contact_details',
            'employment_details','extended_details','roles','photo','contracts','groups','classes']);
    }

    public function getGroups( $school_id ){
        $school = $this->getSchool( $school_id );
        return $school->groups->all(['students','employees']);
    }
    
    public function getClasses( $school_id ){
        $school = $this->getSchool( $school_id );
        return $school->classes->all(['subject','students','employees']);
    }

    public function getAssessments( $school_id ){
        $school = $this->getSchool( $school_id );
        return $school->assessment->all();
    }

    public function getSubjects( $school_id ){
        $school = $this->getSchool( $school_id );
        return $school->subjects->all();
    }
}
