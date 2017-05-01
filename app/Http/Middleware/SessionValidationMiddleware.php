<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;

class SessionValidationMiddleware
{
    public function __construct(OrganisationServiceInterface $orgService)
    {
        $this->orgService = $orgService;
    }

    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure the session is set correctly.
        // The account is generally always set, because you
        // have to select an account as part of the Login
        // process. But we must make a sure these session
        // values are also set:
        // 1. Organisation
		//echo "<pre>"; print_r($request->session()->get('organisation')); die;
        $account_id = $request->session()->get('account');
        $organisation_id = $request->session()->get('organisation');
        if( !$organisation_id ) {
            $organisations = $this->orgService->getOrganisations($account_id);
            $defaultOrganisation = $organisations->first();
            $request->session()->put('organisation', $defaultOrganisation->id);
            $request->session()->put('organisation_slug', $defaultOrganisation->slug);
        }
        return $next($request);
    }
}
