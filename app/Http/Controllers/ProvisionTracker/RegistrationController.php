<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Providers\ProvisionTracker\Api\PackageServiceInterface;
use App\Providers\ProvisionTracker\Api\RegistrationServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Http\Requests;
use App\Http\Requests\RegistrationRequest;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function __construct( PackageServiceInterface $packageService,
                                 RegistrationServiceInterface $registrationService,
                                 AccountServiceInterface $accountService ) {
        $this->packageService = $packageService;
        $this->registrationService = $registrationService;
        $this->accountService = $accountService;
    }

    /**
     * [register description]
     * @return [type] [description]
     */
    public function index( Request $request ) {
        $data = [];
        $data['packages'] = $this->packageService->getPackagesAsOptions();
        $data['account_name'] = $this->registrationService->createAccountname();
        $data['roles'] = $this->getUserRoles( $request->input('type') );
        $data['package'] = $request->input('pkg');
        return \View::make('registration.register', $data);
    }

    /**
     * [submitRegistration description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function submitRegistration( RegistrationRequest $request ) {
        $package_id =  $request->input('package');
        $package = $this->packageService->getPackage( null, $package_id );
        // If no package is selected, use the free trial package
        if( ! $package ) {
            $package = $this->packageService->getPackage( null, 'pt_trial' );
        }
        $registration = $this->registrationService->getRegistrationAssets( $package );
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $slug = str_slug("$first_name $last_name", '-');
        $registration['manager']->first_name =  $first_name;
        $registration['manager']->last_name =  $last_name;
        $registration['manager']->slug = $slug;
        $registration['manager']->email =  $request->input('email');
        $registration['manager']->password =  $request->input('password');
        $registration['manager']->role = $request->input('role');
        // Account details
        // The account name is generated automatically and is hidden
        // from user view. The slug is a legacy var that was used to form
        // part of the url.
        $account_name = $request->input('account_name');
        $registration['account']->name = $account_name;
        $registration['account']->slug = $account_name;
        $response = $this->registrationService->submit( $registration );

        return $response;
    }

    /**
     * [getUserRole description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    private function getUserRoles( $type ){
        if( $type == 'school'){
            return $this->getSchoolRoles();
        }
    }

    /**
     * [getSchoolRoles description]
     * @return [type] [description]
     */
    private function getSchoolRoles() {
        $options = [];
        $option = new \stdClass();
        $option->value = 'head_teacher';
        $option->name = 'Head Teacher';
        $options[] = $option;
        // --------------------------
        $option = new \stdClass();
        $option->value = 'deputy_head';
        $option->name = 'Deputy Head';
        $options[] = $option;
        // --------------------------
        $option = new \stdClass();
        $option->value = 'other';
        $option->name = 'Other';
        $options[] = $option;

        return $options;
    }
}
