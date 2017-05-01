<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;

use App\Providers\ProvisionTracker\Api\ClassServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\TeacherServiceInterface;
use App\Providers\ProvisionTracker\Api\StudentServiceInterface;
use App\Providers\ProvisionTracker\Api\SubjectsServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddClassRequest;

class ClassController extends Controller
{
     public function __construct(ClassServiceInterface $classService,
                                 OrganisationServiceInterface $orgService,
                                 TeacherServiceInterface $teacherService,
                                 StudentServiceInterface $studentService,
                                 UtilsServiceInterface $utilService,
                                 SubjectsServiceInterface $subjectService) {
       $this->classService = $classService;
       $this->orgService = $orgService;
       $this->teacherService = $teacherService;
       $this->studentService = $studentService;
       $this->utilService = $utilService;
       $this->subjectService = $subjectService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ) {
        $page = $request->input('page', 1);
        $data = [];
        $org_slug = \Request::segment(3);
        $organisation = $this->orgService->getOrganisation(null, $org_slug);
        $org_id = $organisation->id;
        $classes = $this->classService->getClasses($org_id);
        $data['class_details'] = $this->utilService->paginateCollection($page, $classes, $request->url());
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('classes/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Classes and Groups');
        });
        // ------------------------------------------
        return \View::make('app.classes.index', $data);
    }

    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function view( Request $request ) {
        $data = [];
        $class_pt_id = \Request::segment(5);
        $org_slug = \Request::segment(3);
        $organisation = $this->orgService->getOrganisation(null, $org_slug);
        $students = $this->studentService->getStudents($organisation);
        $data['class_detail'] = $this->classService->getClass($class_pt_id);
        $data['staff_members'] = $this->teacherService->getStaffAsOptions($organisation->id);
        $data['students'] = $this->classService->getStudentsFromClass($data['class_detail']->id, $organisation->id, $students);
         $data['subjects'] = $this->subjectService->getSubjectsAsOptions( $organisation->id );
         $data['class_staff'] = $this->classService->getClassStaff(  $data['class_detail']->id );
         // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('classes/view', function($breadcrumbs) use ($route_params, $organisation, $data ) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Classes and Groups', route('classes/index', $route_params['all']));
            $breadcrumbs->push( $data['class_detail']->class_name );
        });
        // ------------------------------------------
        return \View::make('app.classes.view', $data);
    }

    /**
     * [add description]
     */
    public function add( Request $request ){
        $data = [];
        $org_slug = \Request::segment(3);
        $organisation = $this->orgService->getOrganisation(null, $org_slug);
        $data['staff_members'] = $this->teacherService->getStaffAsOptions($organisation->id);
        $data['students'] = $this->studentService->getStudents($organisation);
        $data['subjects'] = $this->subjectService->getSubjectsAsOptions( $organisation->id );
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('classes/new', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Classes and Groups', route('classes/index', $route_params['all']));
            $breadcrumbs->push('New');
        });
        // ------------------------------------------
        return \View::make('app.classes.new', $data);
    }

    /**
     * [update description]
     * @param  AddClassRequest $request [description]
     * @return [type]                   [description]
     */
    public function update( AddClassRequest $request ) {
        $class_name = $request->input('class_name');
        $academic_year = $request->input('academic_year');
        $organisation_id = $request->input('organisation_id');
        $class_pt_id = $request->input('class_pt_id');
        $class_id = $request->input('class_id');
        $staff = $request->input('staff');
        $students = $request->input('students');
        $subject_id = $request->input('subject_id');
        $submitted = $this->classService->updateClass($class_id,
                                                      $organisation_id,
                                                      $academic_year,
                                                      $class_name,
                                                      $subject_id,
                                                      $students,
                                                      $staff);
        return back();
    }

    /**
     * [submit description]
     * @param  AddClassRequest $request [description]
     * @return [type]                   [description]
     */
    public function submit( AddClassRequest $request ){
        $class_name = $request->input('class_name');
        $class_academic_year = $request->input('academic_year');
        $organisation_id = $request->input('organisation_id');
        $staff = $request->input('staff');
        $students = $request->input('students');
        $subject_id = $request->input('subject_id');
        $submitted = $this->classService->createClass( $class_name, $class_academic_year, $organisation_id, $subject_id, null, $students, $staff );
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($submitted) ? redirect()->route('classes/index', $route_params) : 'Class Not Created';
    }

    /**
     * [destroy description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function destroy(Request $request) {
        $class_pt_id = $request->input('pt_id');
        $deleted = $this->classService->removeClass($class_pt_id);
        return ($deleted) ? back() : 'Class Can\'t be Deleted';
    }
}
