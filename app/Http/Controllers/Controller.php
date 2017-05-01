<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    public function getDefaultRouteParams($request, $options=null) {
        $data = [];
        // Return everything if nothing is specified
        if( !$options ){
            $data['account_name'] =  $request->session()->get('account_slug');
            $data['org'] =  $request->session()->get('organisation_slug');
        }

        if($options){
            if(isset($options['account_name'])){
                $data['account_name'] =  $request->session()->get('account_slug');
            }
            if(isset($options['org'])){
                $data['org'] =  $request->session()->get('organisation_slug');
            }
        }
        return $data;
    }
}
