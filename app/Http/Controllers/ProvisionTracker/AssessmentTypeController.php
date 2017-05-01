<?php

namespace App\Http\Controllers\ProvisionTracker;
use App\Providers\ProvisionTracker\Api\AssessmentServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AssessmentTypeController extends Controller
{
    public function __construct( AssessmentServiceInterface $assessmentService,
                                 UtilsServiceInterface $utilsService,
                                 OrganisationServiceInterface $orgService ) {
        $this->assessmentService = $assessmentService;
        $this->utilsService = $utilsService;
        $this->orgService = $orgService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data['assessment_types'] = $this->assessmentService->getAssessmentTypes();
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('assessment-types/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Assessment Types');
        });
        // ------------------------------------------
        return \View::make('app.assessment-types.index', $data );
    }

    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function view( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        if( $request->input('mode') == 'copy') {
            $view = $this->viewCopy( $request );
        } else {
            $slug = \Request::segment(5);
            $data = [];
            $data['assessment_type'] = $this->assessmentService->getAssessmentType( null, $slug );
            $data['assessment_type_grades'] = $this->assessmentService->getAssessmentTypeGrades( null, $slug );
            // Provision Tracker views are not editable
            $org_id = $data['assessment_type']->organisation_id;
            $view = ($org_id) ? 'app.assessment-types.view' : 'app.assessment-types.view-locked';
            $view = \View::make($view, $data );
        }
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('assessment-types/view', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Assessment Types', route('assessment-types/index', $route_params['all']));
            $name = $data['assessment_type']->name;
            $breadcrumbs->push($name);
        });
        // ------------------------------------------
        return $view;
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update( Request $request  ) {
        $id = $request->input('assessment_type_id');
        $name = $request->input('assessment_type_name');
        $grades = $request->input('grades');
        $updatedAssessmentType = $this->assessmentService->updateAssessmentType( $id, $name, $grades );
        // Return back to the assessment type;
        $slug = \Request::segment(5);
        $url = $this->utilsService->getUrlBeforeSegment($slug);
        $newSlug = $updatedAssessmentType->slug;
        return redirect("$url$newSlug");
    }

    /**
     * [add description]
     * @param Request $request [description]
     */
    public function add( Request $request ) {

    }

    /**
     * [addCopy description]
     * @param Request $request [description]
     */
    public function copy( Request $request ) {
        $organisation_id= $request->input('organisation_id');
        $orginal_id = $request->input('assessment_type_id');
        $this->assessmentService->copyAssessmentType( $orginal_id, $organisation_id );
        return back();
    }

    /**
     * [destroy description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function destroy( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $id = $request->input('assessment_type_id');
        $this->assessmentService->removeAssessmentType( $organisation->id,$id );
    }

    /**
     * [importDefault description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function importDefault( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $this->assessmentService->removeAssessmentType($organisation->id);
        $file_path = 'resources/assets/assessment-types.xlsx';
        $imported = $this->assessmentService->importDefault( $organisation->id,$file_path );
        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($imported) ? redirect()->route('assessment-types/index', $route_params) : 'Term not imported';
    }

     public function downloadTemplate(Request $request){
        $file_name = 'assessment-types.xlsx';
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
        \Breadcrumbs::register('assessment-types/import', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Assessment Types', route('assessment-types/index', $route_params['all']));

            $breadcrumbs->push('Import Assessment Types');
        });
        return \View::make('app.assessment-types.import',$data);
    }

    public function importAssesments( Request $request ){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $import_type = 'assesment-import';
        $upload_file_path = $this->utilsService->uploadFile($request,$org_id,$import_type );
        $imported = $this->assessmentService->importDefault( $organisation->id,$upload_file_path );
        if($imported){
            $this->utilsService->deleteFile($upload_file_path);
            return 'File Imported';
        }
    }
}
