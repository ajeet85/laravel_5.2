<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Providers\ProvisionTracker\Api\PackageServiceInterface;
use App\Providers\ProvisionTracker\Api\RegistrationServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct( PackageServiceInterface $packageService,
                                 RegistrationServiceInterface $registrationService,
                                 AccountServiceInterface $accountService ) {
        $this->packageService = $packageService;
        $this->registrationService = $registrationService;
        $this->accountService = $accountService;
    }

    /**
     * [login description]
     * @return [type] [description]
     */
    public function login() {
	//echo "gigig"; die;
        return \View::make('login.signin');
    }

    /**
     * [logout description]
     * @return [type] [description]
     */
    public function logout( Request $request ) {
        // Empty the session data for this user
        $request->session()->flush();
        \Auth::logout();
        return \View::make('login.signedout');
    }

    /**
     * [authenticate description]
     * @return [type] [description]
     */
    public function authenticate( Request $request ) {
        $email = $request->input('email');
        $password = $request->input('password');
        if( \Auth::attempt(['email' => $email, 'password' => $password]) ) {
            // Check to see if we need to display
            // an account list for this user to pick from
            $auth_user = \Auth::user();
            $has_multiple_accounts = $this->accountService->hasMultipleAccounts( $auth_user );
            if( $has_multiple_accounts ) {
                return redirect()->intended('/login/select-account/');
            } else {
                // This user only has one account,
                // so sign them into that one immediately
                $account = $this->accountService->getAccounts($auth_user)->first();
                $request->session()->put('account', $account->id);
                return redirect()->intended('/app');
            }

        } else {
            return \View::make('login.signin', ['error'=>'Your email or password is not correct']);
        }
    }

}
