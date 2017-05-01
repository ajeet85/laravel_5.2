<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct( AccountServiceInterface $accountService,
                                 OrganisationServiceInterface $orgService ) {
        $this->accountService = $accountService;
        $this->orgService = $orgService;
    }

    /**
     * [runAdminTask description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     */
    public function confirmAccount( $code ) {
        // Get the type and account id first
        $action_id = $this->accountService->getActionId( $code );
        $account_id = $this->accountService->getActionAccountId( $code );

        // Ask the service to run whatever action was specified
        $status = $this->accountService->confirmAccount( $action_id, $account_id );
        $view = $this->accountService->getAccountActionView( $status );

        // make a demo organisation if the account is confirmed
        if( $status == "confirmed") {
            $org_id = 'pt_trial_org';
            $org_name = "Example Organisation";
            $org_address = "";
            $org_account_id = $account_id;
            $org_type = 1;
            $this->orgService->createOrganisation( $org_id, $org_name, $org_address, $org_account_id, $org_type );
        }

        return \View::make($view);
    }



}
