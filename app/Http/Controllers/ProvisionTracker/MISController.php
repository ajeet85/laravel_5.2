<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers\ProvisionTracker\Api\MISServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;

class MISController extends Controller
{
    public function __construct( AccountServiceInterface $accountService,
                                 OrganisationServiceInterface $orgService,
                                 MISServiceInterface $misService) {
        $this->misService = $misService;
        $this->accountService = $accountService;
        $this->orgService = $orgService;
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index( Request $request ) {
        $data = [];
        $data['services'] = $this->misService->getMISServices();
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $route_params = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('mis/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params));
            $breadcrumbs->push('MIS Sources', route('mis/index', $route_params));
        });
        return \View::make('app.mis-sources.index', $data);
    }

    /**
     * [view description]
     * @return [type] [description]
     */
    public function view( Request $request ) {
        $service_slug = \Request::segment(5);
        $provider_id = $request->input('provider_id');
        $service_id = $request->input('service_id');
        $provider = $this->misService->getProvider($provider_id);
        $data = [];
        $data['service'] = $this->misService->getMISService();
        $data['provider'] = $provider;
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $route_params = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('mis/view', function($breadcrumbs) use ($route_params, $organisation, $data ) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params));
            $breadcrumbs->push('MIS Sources', route('mis/index', $route_params));
            $breadcrumbs->push($data['service']->name, route('mis/index', $route_params));
        });
        return \View::make($provider->template, $data);
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update( Request $request ) {
        $provider_id = $request->input('provider_id');
        $service_id = $request->input('service_id');
        $this->misService->updateService($service_id, $request->all() );
        return back();
    }
}
