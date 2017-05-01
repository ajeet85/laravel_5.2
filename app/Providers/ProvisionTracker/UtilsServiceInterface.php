<?php

namespace App\Providers\ProvisionTracker;


interface UtilsServiceInterface
{
    public function getUrlBeforeSegment( $segment, $url=null );
    public function getUrlAfterSegment( $segment, $url=null);
    public function formatDate( $date );
    public function makeCopyOfName( $name );
    public function createDate( $year, $month, $day, $hour, $minutes, $second );
    public function compareDate( $start_date, $end_date );
    public function dopagination( $data,$max_number_of_records );
    public function paginateCollection( $page, $collection, $path );
}
