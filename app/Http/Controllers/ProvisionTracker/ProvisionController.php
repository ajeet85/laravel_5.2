<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\AddProvisionRequest;
use App\Http\Controllers\Controller;
use App\Providers\ProvisionTracker\Api\ProvisionServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\AreaOfNeedServiceInterface;
use App\Providers\ProvisionTracker\Api\ResourceServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use App\Providers\ProvisionTracker\Api\StudentServiceInterface;
use App\Providers\ProvisionTracker\Api\ClassServiceInterface;
use App\Providers\ProvisionTracker\Api\GroupServiceInterface;
use App\Providers\ProvisionTracker\Api\TeacherServiceInterface;
use App\Providers\ProvisionTracker\Api\TimeSlotServiceInterface;
use Carbon\Carbon;

class ProvisionController extends Controller
{

    public function __construct(ProvisionServiceInterface $provService,
                                OrganisationServiceInterface $orgService,
                                UtilsServiceInterface $utilService,
                                AreaOfNeedServiceInterface $areaofneedService,
                                ResourceServiceInterface $resourceService,
                                StudentServiceInterface $studentService,
                                ClassServiceInterface $classService,
                                GroupServiceInterface $groupService,
                                TeacherServiceInterface $staffService,
                                TimeSlotServiceInterface $timeSlotService )
    {
        $this->provService = $provService;
        $this->orgService = $orgService;
        $this->utilService = $utilService;
        $this->areaofneedService = $areaofneedService;
        $this->resourceService = $resourceService;
        $this->studentService = $studentService;
        $this->classService = $classService;
        $this->groupService = $groupService;
        $this->staffService = $staffService;
        $this->timeSlotService = $timeSlotService;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index( Request $request ) {
        //
        $data = array();
        $page = $request->input('page', 1);

        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $provisions = $this->provService->getProvisions($org_id);
        $data['provisions'] = $this->utilService->paginateCollection($page, $provisions, $request->url());
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('provisions/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Provisions');
        });
        // ------------------------------------------
        return \View::make('app.provisions.index',$data);
    }

    /**
     * Show the form for creating a new provision.
     * @return \Illuminate\Http\Response
     */
    public function add( Request $request )
    {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $data['area_of_need'] = array();
        // Get the available resources
        $this->getAvailableResources( $data, $organisation );
        // Get the allocated resources
        $this->getAllocatedResources( $data );
        $data['provision'] = (object) array('name'=>'','descriptions'=>'','organisation_id'=>'','start_month'=>'','start_day'=>'','start_year'=>'','end_month'=>'','end_day'=>'','end_year'=>'','start_hour'=>'','start_minutes'=>'','end_hour'=>'','end_minute'=>'','msg'=>'');

        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);

        \Breadcrumbs::register('provisions/new', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Provisions', route('provisions/index', $route_params['all']));
            $breadcrumbs->push('New');
        });
        // ------------------------------------------
        return \View::make('app.provisions.new',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit( AddProvisionRequest $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $submitted = $this->provService->createProvision($organisation->id, $request);
        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($submitted) ? redirect()->route('provisions/index', $route_params) : 'Provision can\'t be created';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = array();
        $pt_id = \Request::segment(5);
        $provision = $this->provService->getProvision($pt_id);
        $org_slug = \Request::segment(3);
        $organisation = $this->orgService->getOrganisation(null, $org_slug);
        $org_id = $organisation->id;
        //---------------------------------------------------------------------
        //Get provision Details
        $data['provision'] = $provision;
        // Get the available resources
        $this->getAvailableResources( $data, $organisation );
        // Get the allocated resources
        $this->getAllocatedResources( $data, $provision->id );
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('provisions/view', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Provisions', route('provisions/index', $route_params['all']));
            $breadcrumbs->push($data['provision']->name);
        });
        // ------------------------------------------
        return \View::make('app.provisions.view',$data);
    }


    public function update(AddProvisionRequest $request)
    {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $updated = $this->provService->updateProvision( $organisation->id, $request );
        $provision = $this->provService->getProvision($request->input('pt_id'));
        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        $route_params['provision'] = $provision->pt_id;
        return ($updated) ? redirect()->route('provisions/view', $route_params) : 'Provision Can\'t Be updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pt_id = $request->input('pt_id');
        $deleted = $this->provService->removeProvision($pt_id);
        return ($deleted) ? 'Provision deleted' : 'Provision can\'t be deleted';
    }

    /**
     * [getAvailableResources description]
     * @param  [type] $organisation [description]
     */
    private function getAvailableResources( &$view_data, $organisation ) {
        $view_data['available_times'] = $this->timeSlotService->getTimeSlots($organisation->id)->get();
        $view_data['available_needs'] = $this->areaofneedService->getNeedsAsOptions($organisation->id)->first()->children;
        $view_data['available_students'] = $this->studentService->getStudents($organisation);
        $view_data['available_classes'] = $this->classService->getClasses($organisation->id);
        $view_data['available_groups'] = $this->groupService->getGroups();
        $view_data['available_staff'] = $this->staffService->getStaff($organisation->id,'yes');

        // We need the type ids first before we can get the resources
        $digital_resource_type = $this->resourceService->getResourceType( null, 'digital-resource');
        $physical_resource_type = $this->resourceService->getResourceType( null, 'physical-resource');
        $location_type = $this->resourceService->getResourceType( null, 'location');
        $external_provider_type = $this->resourceService->getResourceType( null, 'external-provider');
        $view_data['available_digital_resources'] = $this->resourceService->getResources($organisation->id, $digital_resource_type->pt_id);
        $view_data['available_physical_resources'] = $this->resourceService->getResources($organisation->id, $physical_resource_type->pt_id);
        $view_data['available_locations'] = $this->resourceService->getResources($organisation->id, $location_type->pt_id);
        $view_data['available_external_providers'] = $this->resourceService->getResources($organisation->id, $external_provider_type->pt_id);
    }

    /**
     * [getAllocatedResources description]
     * @param  [type] $view_data    [description]
     * @param  [type] $organisation [description]
     */
    private function getAllocatedResources( &$view_data, $provision_id=null ) {
        $view_data['allocated_times'] = $this->provService->getAllocatedTimes($provision_id);
        $view_data['allocated_needs'] = $this->provService->getAllocatedAreaOfNeeds($provision_id);
        $view_data['allocated_students'] = $this->provService->getAllocatedStudents($provision_id);
        $view_data['allocated_classes'] = $this->provService->getAllocatedClasses($provision_id);
        $view_data['allocated_groups'] = $this->provService->getAllocatedVulnerableGroup($provision_id);
        $view_data['allocated_staff'] = $this->provService->getAllocatedStaff($provision_id);
        $view_data['allocated_locations'] = $this->provService->getAllocatedLocations($provision_id);
        $view_data['allocated_digital_resources'] = $this->provService->getAllocatedDigitalResources($provision_id);
        $view_data['allocated_physical_resources'] = $this->provService->getAllocatedPhysicalResources($provision_id);
        $view_data['allocated_external_providers'] = $this->provService->getAllocatedExternalProviders($provision_id);
    }

   
   
}
