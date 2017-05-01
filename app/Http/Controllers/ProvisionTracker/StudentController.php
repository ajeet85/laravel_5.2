<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\StudentServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use App\Http\Requests;
use App\Http\Requests\PupilRequest;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * [__construct description]
     * @param StudentServiceInterface      $studentService [description]
     * @param OrganisationServiceInterface $orgService     [description]
     */
    public function __construct( StudentServiceInterface $studentService,
                                 OrganisationServiceInterface $orgService,
                                 UtilsServiceInterface $utilService) {
        $this->studentService = $studentService;
        $this->orgService = $orgService;
        $this->utilService = $utilService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ){
        $data = [];
        $current_organisation_id = $request->session()->get('organisation');
        $organisation = $this->orgService->getOrganisation($current_organisation_id);
        $students = $this->studentService->getStudents( $organisation, false );
        $data['students'] = $this->utilService->dopagination( $students, 15 );
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('pupils/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Pupils and Students');
        });
        // ------------------------------------------
        return \View::make('app.students.index', $data);
    }
    /**
     * [add description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
     public function add(Request $request){
        $data = [];

        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;

        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('pupil/new', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Pupils and Student', route('pupils/index', $route_params['all']));
            $breadcrumbs->push('New');
        });
        return \View::make('app.students.new', $data);
     }

      /**
     * [submit description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
     public function submit(PupilRequest $request){
        $data = [];
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $student_id = $request->input('student_id');
        $gender = $request->input('gender');
        $description = $request->input('description');
        $date_of_birth = \Carbon\Carbon::parse( $request->input('date_of_birth') );
        $submitted = $this->studentService->createStudent($org_id,$first_name,$last_name,$student_id,$date_of_birth,$gender,$description);
        /*// ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('pupil/new', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Pupils and Student', route('pupils/index', $route_params['all']));
            $breadcrumbs->push('New');
        });*/
        return ($submitted) ? 'Student Created' : 'Student can\'t br created';
     }


    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function view( Request $request ){
        $data = [];

        $current_organisation_id = $request->session()->get('organisation');
        $organisation = $this->orgService->getOrganisation($current_organisation_id);
        $pt_id = \Request::segment(5);
        $data['student'] = $this->studentService->getStudent( $organisation, $pt_id );
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('pupils/view', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Pupils and Students', route('pupils/index', $route_params['all']));
            $name = $data['student']->first_name .' '. $data['student']->last_name;
            $breadcrumbs->push($name);
        });
        // ------------------------------------------
        return \View::make('app.students.view', $data);
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update( PupilRequest $request ) {
        $pt_id = \Request::segment(5);
        $current_organisation_id = $request->session()->get('organisation');
        $current_org = $this->orgService->getOrganisation($current_organisation_id);
        $student = $this->studentService->getStudent( $current_org, $pt_id );
        // Update the details
        $student->first_name = $request->input('first_name');
        $student->last_name = $request->input('last_name');
        $student->student_id = $request->input('student_id');
        $dob = \Carbon\Carbon::parse( $request->input('date_of_birth') );
        $student->date_of_birth = $dob;
        $student->gender = $request->input('gender');
        $student->description = $request->input('description');
        $student->save();
        return back();
    }


    public function destroy( Request $request ) {
        $id = $request->input('id');
        $current_organisation_id = $request->session()->get('organisation');
        $current_org = $this->orgService->getOrganisation($current_organisation_id);
        $removed = $this->studentService->removeStudent( $current_org, $id );
        return back();
    }
}
