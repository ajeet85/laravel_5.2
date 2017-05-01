<?php

namespace App\Providers\Mis;


interface WondeServiceInterface
{

    public function getStudents( $school_id );
    public function getEmployees( $school_id );
    public function getGroups( $school_id );
    public function getClasses( $school_id );
    public function getSubjects( $school_id );
}