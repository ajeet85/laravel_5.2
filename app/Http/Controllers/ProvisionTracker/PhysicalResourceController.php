<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Htpp\Requests\ResourceRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\ResourceServiceInterface;

class PhysicalResourceController extends Controller
{
    //
	public function __construct(ResourceServiceInterface $resourceService,OrganisationServiceInterface $orgService){
    	$this->resourceService = $resourceService;
    	$this->orgService = $orgService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ){
        $data = array();
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $digital_type = $this->resourceService->getResourceType(null, 'physical-resource');
        $org_id = $organisation->id;
        $resource_details = $this->resourceService->getResources($org_id, $digital_type->pt_id);
        $data['resource_details'] = $resource_details;
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('physical-resources/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Physical Resources');
        });
        // ------------------------------------------
    	return \View::make('app.resources.index-physical',$data);
    }

    /**
     * [add description]
     * @param Request $request [description]
     */
    public function add( Request $request ){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = array();
        $data['resource_type'] = $this->resourceService->getResourceType( null, 'physical-resource');
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('physical-resources/new', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Physical Resources', route('physical-resources/index', $route_params['all']));
            $breadcrumbs->push('New');
        });
        // ------------------------------------------
        return \View::make('app.resources.new-physical',$data);
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */

    public function submit( Request $request){

 		$resource_name = $request->input('resource_name');
    	$resource_cost = $request->input('resource_cost');
    	$resource_type_id = $request->input('resource_type');
    	$organisation_id = $request->input('organisation_id');

    	$submitted =  $this->resourceService->createResource($resource_name,$resource_cost,$resource_type_id,$organisation_id);
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
    	return ($submitted) ? redirect()->route('physical-resources/index', $route_params) : 'Resource Not Created';
    }

     /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */

     public function view(Request $request){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = array();
        $pt_id = \Request::segment(5);
        $data['resource_data'] = $this->resourceService->getResource($pt_id);
        $data['resource_type'] = $this->resourceService->getResourceType(null, 'physical-resource');
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('physical-resources/view', function($breadcrumbs) use ($route_params, $organisation, $data ) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Physical Resources', route('physical-resources/index', $route_params['all']));
            $breadcrumbs->push($data['resource_data']->name);
        });
        // ------------------------------------------
        return \View::make('app.resources.view-physical',$data);
     }

      /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */

     public function update(ResourceRequest $request){
     	$data = array();
     	$pt_id = $request->input('resource_pt_id');
     	$resource_name = $request->input('resource_name');
    	$resource_cost = $request->input('resource_cost');
    	$resource_type_id = $request->input('resource_type');
    	$organisation_id = $request->input('organisation_id');

     	$updated =  $this->resourceService->updateResource($pt_id,$resource_name,$resource_cost,$resource_type_id,$organisation_id);
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
    	return ($updated) ? redirect()->route('physical-resources/index', $route_params) : 'Resource Not Updated';
     }

      /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */

      public function destroy(Request $request){
      	$pt_id = $request->input('pt_id');
      	$deleted = $this->resourceService->deleteResource($pt_id);
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
      	return ($deleted) ? redirect()->route('physical-resources/index', $route_params) : 'Resource can\'t be Deleted';
      }

}
