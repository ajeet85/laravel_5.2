<?php

namespace App\Http\Middleware;

use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use Closure;

class AccountValidationMiddleware
{
    public function __construct( AccountServiceInterface $accountService,
                                 UtilsServiceInterface $utilsService) {
        $this->accountService = $accountService;
        $this->utilsService = $utilsService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Keep the route associated to the account
        // so the url never gets out of sync.
        // Basically we make sure the account name is
        // part of the url.
        // app/account-name/orgs and NOT app/orgs
        // This middleware call assumes that an account has been selected.
        $segment = \Request::segment(2);
        // Get the account to see if it matches the segment.
        $account_id = $request->session()->get('account');
        $account = $this->accountService->getAccount( $account_id );
        if( $segment != $account->slug) {
            // Put the account name in the right place,
            // then redirect back to the right place.
            $path = $this->utilsService->getUrlAfterSegment( "/$segment" );
            return redirect("/app/$account->slug/$segment$path");
        }
        return $next($request);
    }

}
