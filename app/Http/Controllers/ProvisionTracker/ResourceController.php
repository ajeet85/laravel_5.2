<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ResourceRequest;
use App\Http\Controllers\Controller;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\ResourceServiceInterface;

class ResourceController extends Controller
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
    	$org_slug = \Request::segment(4);
        $organisation = $this->orgService->getOrganisation(null, $org_slug);
        $org_id = $organisation->id;
        $resource_details = $this->resourceService->getResources($org_id);
        $data['resource_details'] = $resource_details;
    	return \View::make('app.resources.index',$data);
    }

    public function add(){
    	$data = array();
    	$data['resource_type'] = $this->resourceService->getResouceTypeAsOptions();
    	return \View::make('app.resources.new',$data);
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
    	return ($submitted) ? 'Resource Created' : 'Resource Not Created';
    }

     /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */

     public function view(Request $request){
     	$data = array();
     	$pt_id = \Request::segment(6);
     	$data['resource_data'] = $this->resourceService->getResource($pt_id);
     	$data['resource_type'] = $this->resourceService->getResouceTypeAsOptions();
     	return \View::make('app.resources.view',$data);
     }

      /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */

     public function update(Request $request){
     	$data = array();
     	$pt_id = $request->input('resource_pt_id');
     	$resource_name = $request->input('resource_name');
    	$resource_cost = $request->input('resource_cost');
    	$resource_type_id = $request->input('resource_type');
    	$organisation_id = $request->input('organisation_id');

     	$updated =  $this->resourceService->updateResource($pt_id,$resource_name,$resource_cost,$resource_type_id,$organisation_id);
    	return ($updated) ? 'Resource Updated' : 'Resource Not Updated';
     }

      /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */

      public function destroy(Request $request){
      	$pt_id = $request->input('pt_id');
      	$deleted = $this->resourceService->deleteResource($pt_id);

      	return ($deleted) ? 'Resource Deleted' : 'Resource can\'t be Deleted';
      }

}
