<?php

namespace App\Providers\ProvisionTracker;
use \Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class UtilsService implements UtilsServiceInterface
{
        /**
         * [getUrlAfterSegemnt description]
         * @param  [type] $segment [description]
         * @return [type]          [description]
         */
    public function getUrlAfterSegment( $delimiter, $path=null ){
        $url = ($path) ? $path : \Request::fullUrl();
        $parts = explode( $delimiter, $url);
        return $parts[1];
    }

    /**
     * [getUrlBeforeSegment description]
     * @param  [type] $delimiter [description]
     * @param  [type] $path      [description]
     * @return [type]            [description]
     */
    public function getUrlBeforeSegment( $delimiter, $path=null ){
        $url = ($path) ? $path : \Request::fullUrl();
        $parts = explode( $delimiter, $url);
        return $parts[0];
    }

    public function formatDate( $date ) {
        $d = explode('-', $date);
        $new_date = Carbon::createFromDate( $d[0], $d[1], $d[2] );
        return $new_date->format('d F Y');
    }

    public function makeCopyOfName( $name ) {
        $index = filter_var($name, FILTER_SANITIZE_NUMBER_INT) || 0;
        $index++;
        $parts = explode('copy', $name);
        return "$parts[0] copy $index";
    }

    public function createDate($year, $month, $day, $hour, $minutes, $second){
         $tz = 'Europe/London';
         $date = Carbon::create($year, $month, $day, $hour, $minutes, $second, $tz);
         return $date;
    }

    public function compareDate( $start_date, $end_date ){
        if($start_date > $end_date)
            return 0;
        else
            return 1;

    }

    public function dopagination( $data,$max_number_of_records ){
        return $data->paginate($max_number_of_records);
    }

    /**
     * [paginateCollection description]
     * @param  [type] $page       [description]
     * @param  [type] $collection [description]
     * @return [type]             [description]
     */
    public function paginateCollection( $page, $collection, $path ){
        $set = $collection->forPage($page, 15)->all();
        $paginator = new LengthAwarePaginator($set, count($collection), 15, $page);
        $paginator->setPath($path);
        return $paginator;
    }

    /**
     * [downloadTemplate Description]
     * @param [type] $file_name [description]
     * @return [type] [description]
     */
    public function downloadTemplate( $template_name ){
         $file_path = public_path('../resources/assets/'.$template_name);
         return response()->download($file_path);
    }

    public function uploadFile($request,$org_id,$import_type ){
        $destination_path = storage_path('app/uploads');// upload path
        $extension = $request->file('file_name')->getClientOriginalExtension(); // getting file extension
        $file_name = $org_id.$import_type.'.'.$extension; // renameing image

        $request->file('file_name')->move($destination_path, $file_name);
        $file_path = 'storage/app/uploads/'.$file_name;
        return $file_path;
    }
    public function deleteFile( $path ){
        $file_path = base_path().'/'.$path;
        return unlink($file_path);
    }

}
