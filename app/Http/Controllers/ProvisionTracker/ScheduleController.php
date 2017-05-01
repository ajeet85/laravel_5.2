<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers\ProvisionTracker\Api\ProvisionServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    //
     public function __construct( ProvisionServiceInterface $provService,
     							  OrganisationServiceInterface $orgService,
                                  UtilsServiceInterface $utilService ){
     	$this->provService = $provService;
        $this->orgService = $orgService;
        $this->utilService = $utilService;
     }

     public function view(Request $request){
     	$data = [];
     	$org_id = $request->session()->get('organisation');
     	$date = Carbon::now();
     	$data['schedule_date'] = $date->format('l jS \\of F Y');
     	$provisions = $this->provService->getScheduleProvisions( $org_id,$date->toDateString() );
     	$provision_scheduled = $this->provService->checkProvisionRuns( $provisions,$date );
     	$data['provisions'] = $provision_scheduled;
     	 return \View::make('app.schedule.view',$data);;
     }
}
