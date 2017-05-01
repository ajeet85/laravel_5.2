<?php

namespace App\Http\Controllers\ProvisionTracker;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\TimeSlotServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TimeSlotController extends Controller
{
    public function __construct( TimeSlotServiceInterface $timeSlotService,
                                 UtilsServiceInterface $utilsService,
                                 OrganisationServiceInterface $orgService ) {
        $this->timeSlotService = $timeSlotService;
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
        $times = $this->timeSlotService->getTimeSlots($organisation->id);
        $paginated = $this->utilsService->dopagination($times, 15);
        $data['times'] = $paginated;
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('time-slots/index', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Time Slots');
        });
        // ------------------------------------------
        return \View::make('app.time-slots.index', $data );
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
        \Breadcrumbs::register('time-slots/new', function($breadcrumbs) use ($route_params, $organisation) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Time Slots', route('time-slots/index', $route_params['all']));
            $breadcrumbs->push('New');
        });
        // ------------------------------------------
        return \View::make('app.time-slots.new', $data );
    }

    /**
     * [add description]
     * @param Request $request [description]
     */
    public function submit( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $inserted = $this->timeSlotService->addTimeSlot( $organisation->id, $request );

        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($inserted) ? redirect()->route('time-slots/index', $route_params) : 'Time Slot not added';
    }

    /**
     * [view description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function view( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $data = [];
        $data['time'] = $this->timeSlotService->getTimeSlot($organisation->id, null, \Request::segment(5));
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('time-slots/view', function($breadcrumbs) use ($route_params, $organisation, $data) {
            $breadcrumbs->push($organisation->name, route('orgs/view', $route_params['all']));
            $breadcrumbs->push('Time Slots', route('time-slots/index', $route_params['all']));
            $breadcrumbs->push($data['time']->name );
        });
        // ------------------------------------------
        return \View::make('app.time-slots.view', $data );
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update( Request $request ) {
        $organisation = $this->orgService->getOrganisation(null, \Request::segment(3));
        $updated = $this->timeSlotService->updateTimeSlot( $organisation->id, null, \Request::segment(5), $request );

        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        $route_params['timeslot'] = $updated->pt_id;
        return ($updated) ? redirect()->route('time-slots/view', $route_params) : 'Time Slot not added';
    }

    public function destroy( Request $request ) {
        $org_id = $request->input('organisation_id');
        $pt_id = $request->input('pt_id');
        $removed = $this->timeSlotService->removeTimeSlot($org_id, null, $pt_id);

        // Generate a url for the return call
        $route_params = parent::getDefaultRouteParams($request);
        return ($removed) ? redirect()->route('time-slots/index', $route_params) : 'Time Slot not removed';
    }
}
