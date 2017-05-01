<?php

namespace App\Http\Controllers\ProvisionTracker;

use App\Providers\ProvisionTracker\Api\AreaOfNeedServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAreaOfNeedRequest;


class AreaOfNeedController extends Controller
{
    //
    public function __construct(AreaOfNeedServiceInterface $areaofneedService,OrganisationServiceInterface $orgService,
        UtilsServiceInterface $utilsService){
        $this->areaofneedService = $areaofneedService;
        $this->orgService = $orgService;
        $this->utilsService = $utilsService;
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index( Request $request ){
        $data = [];
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $area_of_need_details = $this->areaofneedService->getAreaOfNeeds($org_id);
        $data['needs'] = $area_of_need_details->first()['children'];
        $data['needs_as_options'] = $this->areaofneedService->getNeedsAsOptions($org_id);
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('needs/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Areas of Need');
        });
        // ------------------------------------------
        return \View::make('app.areaofneed.index', $data);
    }

    /**
     * [add description]
     * @param Request $request [description]
     */
    public function add( Request $request ){
        $data = [];
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $area_of_need_details = $this->areaofneedService->getNeedsAsOptions($org_id);
        $data['needs'] = $area_of_need_details;
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('needs/new', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Areas of Need', route('needs/index', $route_params['all']));
            $breadcrumbs->push('New');
        });
        // ------------------------------------------
    	return \View::make('app.areaofneed.new',$data);
    }

    /**
     * [submit description]
     * @param  AddAreaOfNeedRequest $request [description]
     * @return [type]                        [description]
     */
    public function submit(AddAreaOfNeedRequest $request){
    	$area_of_need_name = $request->input('name');
    	$area_of_need_description = $request->input('areaofneed_description');
    	$organisation_id =  $request->input('organisation_id');
        $parent_id = $request->input('parent_id');
    	$submitted = $this->areaofneedService->createAreaOfNeed($organisation_id,$area_of_need_name,$area_of_need_description,$parent_id);
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($submitted) ? redirect()->route('needs/index', $route_params):'Can\'t Create Area Of Need';
    }

    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function view( Request $request ){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
    	$data = [];
    	$pt_id = \Request::segment(6);
    	$area_of_need_detail = $this->areaofneedService->getAreaOfNeed($org_id,$pt_id);
    	$data['need'] = $area_of_need_detail;

        $area_of_need_details = $this->areaofneedService->getAreaOfNeeds($org_id);
        $data['needs'] = $area_of_need_details->first()['children'];
        $data['needs_as_options'] = $this->areaofneedService->getNeedsAsOptions($org_id);
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('needs/view', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['account_name']));
            $breadcrumbs->push('Areas of Need', route('needs/index', $route_params['all']));
            $breadcrumbs->push($data['need']->name);
        });
        // ------------------------------------------
    	return \View::make('app.areaofneed.view',$data);
    }

    /**
     * [update description]
     * @param  AddAreaOfNeedRequest $request [description]
     * @return [type]                        [description]
     */
    public function update(AddAreaOfNeedRequest $request){
    	$data = [];
    	$pt_id = $request->input('areaofneed_pt_id');
    	$org_id = $request->input('organisation_id');
    	$area_of_need_name = $request->input('name');
    	$areaofneed_description = $request->input('areaofneed_description');
    	$updated = $this->areaofneedService->updateAreaOfNeed($pt_id,$org_id,$area_of_need_name,$areaofneed_description);
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        $route_params['need'] = $pt_id;
        return ($updated) ? redirect()->route('needs/view', $route_params) : 'Area Of Need Not Updated';
    }

    public function destroy(Request $request){
        $pt_id = \Request::segment(5);
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $deleted = $this->areaofneedService->removeAreaOfNeed($organisation->id,null,$pt_id);
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($deleted) ? redirect()->route('needs/index', $route_params) : 'Area Of Need Can\'t Be Deleted';
    }

     /**
     * [importDefault description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function importDefault( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $file_path = 'resources/assets/areas-of-need.xlsx';
        $del_area_of_need = $this->areaofneedService->removeAreaOfNeed($organisation->id);
        $imported = $this->areaofneedService->importDefault( $organisation->id,$file_path );
        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($imported) ? redirect()->route('needs/index', $route_params) : 'Term not imported';
    }

    public function import( Request $request ){
        $data = [];
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('need/import', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Areas of Need', route('needs/index', $route_params['all']));
            $breadcrumbs->push('Import Area Of Need');
        });
        return \View::make('app.areaofneed.import',$data);
    }

    public function downloadTemplate(Request $request){
        $file_name = 'areas-of-need.xlsx';
        $data = [];

        // ------------------------------------------
        $get_file = $this->utilsService->downloadTemplate( $file_name );
        return $get_file;
    }

    public function importNeed(Request $request){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $import_type = 'need-import';
        $upload_file_path = $this->utilsService->uploadFile($request,$org_id,$import_type );
        $imported = $this->areaofneedService->importDefault( $organisation->id,$upload_file_path );
        if($imported){
            $this->utilsService->deleteFile($upload_file_path);
            return 'File Imported';
        }

    }
}
