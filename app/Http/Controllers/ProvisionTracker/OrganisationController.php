<?php

namespace App\Http\Controllers\ProvisionTracker;

use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use App\Providers\ProvisionTracker\Api\UKSchoolServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddOrganisationRequest;

class OrganisationController extends Controller
{
    public function __construct( OrganisationServiceInterface $orgService,
                                 AccountServiceInterface $accountService,
                                 UtilsServiceInterface $utilsService,
                                 UKSchoolServiceInterface $schoolService ) {
        $this->accountService = $accountService;
        $this->orgService = $orgService;
        $this->utilsService = $utilsService;
        $this->schoolService = $schoolService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ) {
        if( $request->has('q') ) {
            return $this->search( $request );
        }
        $account_id = $request->session()->get('account');
        $data = [];
        $data['user_organisations'] = $this->orgService->getOrganisations($account_id);
        $data['org_types'] = $this->orgService->getTypesAsOptions();
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('orgs/index', function($breadcrumbs) use ($route_params) {
            $breadcrumbs->push('Organisations', route('orgs/index', $route_params));
        });
        // ------------------------------------------
        return \View::make('app.orgs.index', $data);
    }

    /**
     * [search description]
     * @return [type] [description]
     */
    public function search( Request $request ) {
        $account_id = $request->session()->get('account');
        $query = $request->input('q');
        $data = [];
        $data['user_organisations'] = $this->orgService->getOrganisations($account_id, $query);
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('orgs/index', function($breadcrumbs) use ($route_params) {
            $breadcrumbs->push('Organisations', route('orgs/index', $route_params));
        });
        // ------------------------------------------
        return \View::make('app.orgs.index', $data);
    }

    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function view( Request $request ){
        $data = [];
        $org_slug = \Request::segment(4);
        $organisation = $this->orgService->getOrganisation(null, $org_slug);
        $data['organisation'] = $organisation;
        $data['org_types'] = $this->orgService->getTypesAsOptions();
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('orgs/view', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push('Organisations', route('orgs/index', $route_params['account_name']));
            $breadcrumbs->push($organisation->name);
        });
        // ------------------------------------------
        return \View::make('app.orgs.view', $data);
    }

    /**
     * [newOrganisation description]
     * @return [type] [description]
     */
    public function add( Request $request ) {
        $organisation_type = $this->orgService->getTypes( $request->input('org_type') )->first();
        $data = [];
        $schools = $this->schoolService->getSchool( $request );
        $data['user_organisations'] = $this->utilsService->paginateCollection( 1, $schools, $request->url());
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('orgs/find', function($breadcrumbs) use ($route_params, $organisation_type) {
            $breadcrumbs->push('Organisations', route('orgs/index', $route_params['account_name']));
            $breadcrumbs->push("New $organisation_type->label");
        });
        return \View::make("app.orgs.new-$organisation_type->slug", $data);
    }

    /**
     * [find description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function find( Request $request ){
        $organisation_type = $this->orgService->getTypes( $request->input('org_type') )->first();
        $data = [];
        if( $organisation_type->label == 'School') {
            $results = $this->schoolService->getSchool( $request );
        }
        if( count($results) > 0 ) {
            $results = $this->utilsService->dopagination( $results, 15 );
        } else {
            $results = $this->utilsService->paginateCollection( 1, $results, $request->url());
        }
        $data['user_organisations'] = $results;
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('orgs/find', function($breadcrumbs) use ($route_params, $organisation_type) {
            $breadcrumbs->push('Organisations', route('orgs/index', $route_params['account_name']));
            $breadcrumbs->push("New $organisation_type->label");
        });
        return \View::make("app.orgs.new-$organisation_type->slug", $data);

    }

    /**
     * [delete description]
     * @return [type] [description]
     */
    public function destroy( Request $request ) {
        $id = $request->input('id');
        $removed = $this->orgService->removeOrganisation( $id );
        return ($removed) ? 'Org removed' : 'Org not removed';
    }

    /**
     * [submitOrganisation description]
     * @return [type] [description]
     */
    public function submit( AddOrganisationRequest $request ) {
        $organisation_type = $this->orgService->getTypes( $request->input('org_type') )->first();
        if( $organisation_type->label == 'School') {
            return $this->claimSchool( $request );
        }
    }

    /**
     * [claimSchool description]
     * @param  AddOrganisationRequest $request [description]
     * @return [type]                          [description]
     */
    private function claimSchool( AddOrganisationRequest $request ) {
        $dfe_number = $request->input('org_id');
        $org_name = $request->input('org_name');
        $org_address = $request->input('org_address');
        $org_account_id = $request->input('account_id');
        $org_type = $request->input('org_type');
        $submitted = $this->orgService->createOrganisation($dfe_number, $org_name, $org_address, $org_account_id, $org_type);

        if( $submitted ) {
            // Who ever claims this school has FULL access to this account
            // Anyone that connects to it, has restrcited access only
            $this->orgService->setAccess( $dfe_number, 'FULL');
            // All fields in this request must be complete!!
            $this->schoolService->claimSchool( $dfe_number, \Auth::user()->pt_id );
        }

        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($submitted) ? redirect()->route('orgs/index', $route_params) : 'Org not created';
    }

    /**
     * [update description]
     * @return [type] [description]
     */
    public function update( AddOrganisationRequest $request ) {
        $id = $request->input('id');
        $org_id = $request->input('org_id');
        $org_name = $request->input('org_name');
        $org_address = $request->input('org_address');
        $org_account_id = $request->input('account_id');
        $org_type = $request->input('org_type');
        $updated = $this->orgService->updateOrganisation($id, $org_id, $org_name, $org_address, $org_type);
        // Reload using the organisation slug
        $slug = $this->orgService->getOrganisation( $id )->slug;
        return redirect("/app/orgs/$slug");
    }

    /**
     * [switchOrganisation description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function switchOrganisation(Request $request) {
        $org_id = $request->input('org_id');
        $current_org = $this->orgService->getOrganisation($org_id);
        $request->session()->put('organisation', $org_id);
        $request->session()->put('organisation_slug', $current_org->slug);
        // Only update the url if it has an organisation,
        // otherwise, just update the session and return.
        // We can't use segments here, as the url will have changed
        // to the 'switch' route. use the path supplied to the switcher
        $current_path = $request->input('current_path');
        $path_parts = explode('/', $current_path);
        // return $path_parts;
        if( count($path_parts) > 4 )
        {
            $segment = $path_parts[4];
            $before_path = $this->utilsService->getUrlBeforeSegment( "/$segment", $current_path );
            $after_path = $this->utilsService->getUrlAfterSegment( "/$segment", $current_path );
            // Organisations will have different assets, so we can't
            // always deep link to an asset in another organisation.
            // Instead we just switch them back to the first level:
            // /teacher, or /pupils, or /settings and NOT:
            // /teacher/miss-mclusky as she might not exist in another organisation
            if( strlen($after_path) > 1) {
                $after_path = "/".explode('/', $after_path)[1];
            }

            return redirect("$before_path/$current_org->slug$after_path");
        } else {
            return back();
        }

    }

}
