<?php

namespace App\Http\Controllers\ProvisionTracker;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\TermServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\TermRequest;
use App\Http\Controllers\Controller;

class TermsController extends Controller
{
    public function __construct( TermServiceInterface $termService,
                                 UtilsServiceInterface $utilsService,
                                 OrganisationServiceInterface $orgService ) {
        $this->termService = $termService;
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
        $data = [];
        $data['terms'] = $this->termService->getTerms($organisation->id);
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('terms/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Terms');
        });
        // ------------------------------------------
        return \View::make('app.term-dates.index', $data );
    }

    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function add( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = [];
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('terms/new', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Terms', route('terms/index', $route_params['all']));
            $breadcrumbs->push('New');
        });
        // ------------------------------------------
        return \View::make('app.term-dates.new', $data );
    }

    /**
     * [add description]
     * @param Request $request [description]
     */
    public function submit( TermRequest $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $inserted = $this->termService->addTerm( $organisation->id, $request );
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('terms/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Terms');
        });
        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($inserted) ? redirect()->route('terms/index', $route_params) : 'Term not added';
    }

    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function view( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = [];
        $data['term'] = $this->termService->getTerm( $organisation->id,null, \Request::segment(5) );
        $data['term']->start_date = $this->utilsService->formatDate($data['term']->start_date);
        $data['term']->end_date = $this->utilsService->formatDate($data['term']->end_date);
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('terms/view', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Terms', route('terms/index', $route_params['all']));
            $breadcrumbs->push($data['term']->name);
        });
        // ------------------------------------------
        return \View::make('app.term-dates.view', $data );
    }

    /**
     * [update description]
     * @return [type] [description]
     */
    public function update( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $updated_term = $this->termService->updateTerm( null, \Request::segment(5), $request );
        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        $route_params['term'] = $updated_term->pt_id;
        return ($updated_term) ? redirect()->route('terms/view', $route_params) : 'Term not updated';
    }

    /**
     * [importDefault description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function importDefault( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $this->termService->removeTerm($organisation->id);
        $file_path = 'resources/assets/term-dates.xlsx';
        $imported = $this->termService->importDefault( $organisation->id,$file_path );
        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($imported) ? redirect()->route('terms/index', $route_params) : 'Term not imported';
    }

    /**
     * [destroy description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function destroy( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $removed = $this->termService->removeTerm( $organisation->id, null, $request->input('pt_id') );
        // ------------------------------------------
        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($removed) ? redirect()->route('terms/index', $route_params) : 'Term not removed';
    }

    public function import( Request $request ){
        $data = [];
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('terms/import', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Terms', route('terms/index', $route_params['all']));
            $breadcrumbs->push('Import Terms');
        });
        return \View::make('app.term-dates.import',$data);
    }


    public function downloadTemplate(Request $request){
        $file_name = 'term-dates.xlsx';
        $data = [];

        // ------------------------------------------
        $get_file = $this->utilsService->downloadTemplate( $file_name );
        return $get_file;
    }

    public function importTerm(Request $request){
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $org_id = $organisation->id;
        $import_type = 'term-import';
        $upload_file_path = $this->utilsService->uploadFile($request,$org_id,$import_type );
        $imported = $this->termService->importDefault( $organisation->id,$upload_file_path );
        if($imported){
            $this->utilsService->deleteFile($upload_file_path);
            return 'File Imported';
        }

    }
}
