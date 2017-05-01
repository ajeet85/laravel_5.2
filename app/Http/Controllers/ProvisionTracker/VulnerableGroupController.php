<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use App\Providers\ProvisionTracker\Api\GroupServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Http\Requests;
use App\Http\Requests\AddVulnerableGroupRequest;
use App\Http\Controllers\Controller;

class VulnerableGroupController extends Controller
{
    public function __construct( UtilsServiceInterface $utilsService,GroupServiceInterface $groupService,
         OrganisationServiceInterface $orgService ) {
        $this->utilsService = $utilsService;
        $this->groupService = $groupService;
        $this->orgService = $orgService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ) {
        $data = [];
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $data['groups_detail'] = $this->groupService->getGroups($org_id);
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('vulnerablegroups/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Vulnerable Groups');
        });
        // ------------------------------------------
        return \View::make('app.groups.index', $data);
    }

    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function view( Request $request ){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = [];
        $pt_id = \Request::segment(6);
        $data['group_detail'] = $this->groupService->getGroup($organisation->id,$pt_id);
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('vulnerablegroups/view', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Vulnerable Groups', route('vulnerablegroups/index', $route_params['all']));
            $breadcrumbs->push($data['group_detail']->name);
        });
        // ------------------------------------------
        return \View::make('app.groups.view', $data);
    }

    /**
     * [newOrganisation description]
     * @return [type] [description]
     */
    public function add( Request $request ) {
        $data = [];

        return \View::make('app.groups.new', $data);
    }


    /**
     * [submitOrganisation description]
     * @return [type] [description]
     */
    public function submit( AddVulnerableGroupRequest $request ) {
        $org_id = $request->input('organisation_id');
        $group_name = $request->input('group_name');
        $group_description = $request->input('description');
        $slug = str_slug($group_name,'-');
        $submitted = $this->groupService->createGroup($org_id,$group_name,$group_description,$slug);
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($submitted) ? redirect()->route('vulnerablegroups/index', $route_params) : 'Group not created';
    }

    /**
     * [update description]
     * @return [type] [description]
     */
    public function update( AddVulnerableGroupRequest $request ) {
        $pt_id = $request->input('class_pt_id');
        $org_id = $request->input('organisation_id');
        $group_name = $request->input('group_name');
        $group_description = $request->input('description');
        $slug = str_slug($group_name,'-');
        $updated = $this->groupService->updateGroup($pt_id,$org_id,$group_name,$group_description,$slug);
        return ($updated) ? 'Group Updated' : 'Group not Updated';
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $pt_id = $request->input('pt_id');
        $deleted = $this->groupService->removeGroup( $organisation->id, null,$pt_id );
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($deleted) ? redirect()->route('vulnerablegroups/index', $route_params) : 'Group Can\'t be deleted';
    }

     /**
     * [importDefault description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function importDefault( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $this->groupService->removeGroup($organisation->id);
        $file_path = 'resources/assets/vulnerable-groups.xlsx';
        $imported = $this->groupService->importDefault( $organisation->id,$file_path );
        // ------------------------------------------
        // Generate a url for the return call

        $route_params = parent::getDefaultRouteParams($request);
        return ($imported) ? redirect()->route('vulnerablegroups/index', $route_params) : 'Term not imported';
    }
    public function downloadTemplate(Request $request){
        $file_name = 'vulnerable-groups.xlsx';
        $data = [];

        // ------------------------------------------
        $get_file = $this->utilsService->downloadTemplate( $file_name );
        return $get_file;
    }
    public function import( Request $request ){
        $data = [];
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('vulnerablegroups/import', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Vulnerable Groups', route('vulnerablegroups/index', $route_params['all']));
            $breadcrumbs->push('Import Vulnerable Group');
        });
        return \View::make('app.groups.import',$data);
    }

    public function importGroups( Request $request ){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $import_type = 'group-import';
        $upload_file_path = $this->utilsService->uploadFile($request,$org_id,$import_type );
        $imported = $this->groupService->importDefault( $organisation->id,$upload_file_path );
        if($imported){
            $this->utilsService->deleteFile($upload_file_path);
            return 'File Imported';
        }
    }
}
