<?php

namespace App\Http\Controllers\ProvisionTracker;

use App\Providers\ProvisionTracker\Api\PackageServiceInterface;
use App\Providers\ProvisionTracker\Api\RegistrationServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function __construct( PackageServiceInterface $packageService,
                                 RegistrationServiceInterface $registrationService,
                                 AccountServiceInterface $accountService ) {
        $this->packageService = $packageService;
        $this->registrationService = $registrationService;
        $this->accountService = $accountService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ) {
	
        $authUser = \Auth::user();
        $accounts = $this->accountService->getAccounts( $authUser, 'active');
        return \View::make('app.dashboard', ['accounts'=>$accounts, 'user'=>$authUser]);
    }

    /**
     * [selectAccount description]
     * @return [type] [description]
     */
    public function displayAccountsForSelection() {
        // The Auth doesn't return the right type of user
        $authUser = \Auth::user();
        // Get all the accounts the user belongs to
        $accounts = $this->accountService->getAccounts( $authUser, 'active');
        return \View::make('app.account-selection', ['accounts'=>$accounts]);
    }

    /**
     * [selectAccount description]
     * @return [type] [description]
     */
    public function selectAccount( Request $request ) {
        $account_id = $request->input('account');
        $account_slug = $this->accountService->getAccount($account_id)->slug;
        $request->session()->put('account', $account_id);
        $request->session()->put('account_slug', $account_slug);
        return redirect('/app');
    }
}
