<?php

namespace App\Http\Middleware;

use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use Closure;

class AccountSelectionMiddleware
{
    public function __construct( AccountServiceInterface $accountService ) {
        $this->accountService = $accountService;
    }
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check to see if an account has been selected.
        // If one is found, redirect to that account.
        // Otherwise redirect back to account selection
        if ($request->session()->has('account')) {
            // Get the account we should forward the request on to.
            $account_id = $request->session()->get('account');
            $account = $this->accountService->getAccount( $account_id );
            return redirect("/app/$account->name");
        } else {
            return redirect("/login/select-account");
        }
        return $next($request);
    }
}
