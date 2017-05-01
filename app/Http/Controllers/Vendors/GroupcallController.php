<?php

namespace App\Http\Controllers\Vendors;

use Illuminate\Http\Request;
use App\Providers\ProvisionTracker\Api\MISServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Carbon\Carbon;

class GroupcallController extends Controller
{
    public function __construct( MISServiceInterface $misService ) {
        $this->misService = $misService;
        $this->root_path = dirname(dirname(dirname(dirname(__DIR__))));
        $this->local_storage_path = $this->root_path . '/resources';
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index( Request $request ) {
        $groupcall = $this->misService->getProvider( null, null, 'groupcall');
        $school_id = \Request::header('SchoolId');
        $service = $this->misService->getSchoolService( $school_id );

        if( ! $service ) {
            $message['code'] = '400';
            $message['status'] = 'Error';
            $message['message'] = 'The school you are looking cannot be found. Please try another id';
            return response()->json($message);
        }

        if( ! $this->authorised($service) ) {
            $message['code'] = '401';
            $message['status'] = 'Error';
            $message['message'] = 'There is a Username / Password mismatch for this School';
            return response()->json($message);
        }

        $adapter = new Local( $this->local_storage_path );
        $filesystem = new Filesystem( $adapter );
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = $school_id.'_'.$timestamp .'.xml';
        $filesystem->write($filename, \Request::getContent());
        $check_path = $this->local_storage_path . "/$filename";

        if( file_exists($check_path) ) {
            $message['code'] = '200';
            $message['status'] = 'Success';
            $message['message'] = 'Data upload successful';
            return response()->json($message);
        }
    }

    /**
     * [authorised description]
     * @param  [type] $user     [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function authorised( $service ) {
        $response = false;
        $user_match = $service->username == \Request::header('php-auth-user');
        $password_match = \Hash::check( \Request::header('php-auth-pw'), $service->password);
        if( $user_match && $password_match ) {
            $response = true;
        }
        return $response;
    }

}
