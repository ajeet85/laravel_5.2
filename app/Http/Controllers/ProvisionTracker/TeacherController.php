<?php
namespace App\Http\Controllers\ProvisionTracker;

use App\Providers\ProvisionTracker\Api\TeacherServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddStaffRequest;

class TeacherController extends Controller
{
    public function __construct(TeacherServiceInterface $staffService,
                                OrganisationServiceInterface $orgService,
                                UtilsServiceInterface $utilService) {
       $this->staffService = $staffService;
       $this->orgService = $orgService;
       $this->utilService = $utilService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ) {
        $data = [];
        $org_slug = \Request::segment(3);
        $organisation = $this->orgService->getOrganisation(null, $org_slug);
        $org_id = $organisation->id;
        $page = $request->input('page', 1);
        $staff_details = $this->staffService->getStaff($org_id,null);
        $data['staff_details'] = $this->utilService->paginateCollection($page, $staff_details, $request->url());
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('teachers/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Staff Members');
        });
        return \View::make('app.teachers.index', $data);
    }

    /**
     * [add description]
     */
    public function add( Request $request  ){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = [];
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('teachers/new', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Staff Members', route('teachers/index', $route_params['all']));
            $breadcrumbs->push('New');
        });
        // ------------------------------------------
        return \View::make('app.teachers.new',$data);
    }

    /**
     * [submit description]
     * @param  AddStaffRequest $request [description]
     * @return [type]                   [description]
     */
    public function submit( AddStaffRequest $request ) {
        $staff = array();
        $staff['first_name'] = $request->input('first_name');
        $staff['last_name'] = $request->input('last_name');
        $staff['slug'] = str_slug($staff['first_name'].' '.$staff['last_name'], '-');
        $staff['description'] = $request->input('staff_description');
        $staff['cost'] = $request->input('staff_cost');
        $staff['organisation_id'] = $request->input('organisation_id');
        $staff['provider'] = $request->input('is_provider');
        $submitted = $this->staffService->createStaff($staff);
        return ($submitted) ? 'Staff created' : 'Staff not created';
    }

    /**
     * [view description]
     * @return [type] [description]
     */
    public function view( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = [];
        $staff_pt_id = \Request::segment(6);
        $data['staff_details'] = $this->staffService->getStaffDetails($staff_pt_id);
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('teachers/view', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Staff Members', route('teachers/index', $route_params['all']));
            $name = $data['staff_details']->first_name .' '. $data['staff_details']->last_name;
            $breadcrumbs->push($name);
        });
        // ------------------------------------------
        return \View::make('app.teachers.view', $data);
    }

    public function update(AddStaffRequest $request) {
        $staff = array();
        $staff['pt_id'] = $request->input('staff_pt_id');
        $staff['first_name'] = $request->input('first_name');
        $staff['last_name'] = $request->input('last_name');
        $staff['description'] = $request->input('staff_description');
        $staff['slug'] = str_slug($staff['first_name'].' '.$staff['last_name'], '-');
        $staff['cost'] = $request->input('staff_cost');
        $staff['organisation_id'] = $request->input('organisation_id');
        $staff['provider'] = $request->input('is_provider');
        $submitted = $this->staffService->updateStaffDetails($staff);
        return back();
    }

    public function destroy(Request $request) {
        $staff_pt_id = $request->input('pt_id');
        $removed = $this->staffService->removeStaff($staff_pt_id);
        return ($removed) ? 'Staff removed' : 'Staff not removed';
    }

}
