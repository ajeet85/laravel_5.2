<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Provision;
use App\Models\ProvisionsAreaOfNeed;
use App\Models\ProvisionResources;
use App\Models\ProvisionStudents;
use App\Models\ProvisionClasses;
use App\Models\ProvisionTime;
use App\Models\ProvisionVulnerableGroup;
use App\Models\ProvisionStaff;
use App\Models\ProvisionDigitalResource;
use App\Models\ProvisionExternalProvider;
use App\Models\ProvisionHumanResource;
use App\Models\ProvisionLocation;
use App\Models\ProvisionPhysicalResource;
use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use Carbon\Carbon;
use DB;

class ProvisionService implements ProvisionServiceInterface
{
    public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
        $this->max_no_of_records_per_page = 5;
        DB::enableQueryLog();
    }

    /**
     * [createProvision description]
     * @param  [type] $org_id     [description]
     * @param  [type] $name       [description]
     * @param  [type] $address    [description]
     * @param  [type] $account_id [description]
     * @param  [type] $type_id    [description]
     * @return [type]             [description]
     */
    public function createProvision( $organisation_id, $request) {
        $provision = new Provision;
        $provision->organisation_id = $organisation_id;
        $provision->pt_id = $this->idService->ptId();
        $provision->name = $request->input('name');
        $provision->description = $request->input('description');
        $provision->slug = str_slug($request->input('name'),'-');
        $saved = $provision->save();

        if($saved){
            //--------------------------------------------
            // Add the neccessary assets to the provision
            $id = $provision->id;
            $this->addAssetsToProvision( $id, $request );
        }
        return $saved;
    }

    /**
     * [updateOrganisation description]
     * @param  [type] $id      [description]
     * @param  [type] $org_id  [description]
     * @param  [type] $name    [description]
     * @param  [type] $address [description]
     * @param  [type] $type_id [description]
     * @return [type]          [description]
     */
    public function updateProvision( $organisation_id, $request ) {
        $query = [];
        $query[] = ['id', $request->input('id')];
        // Core changed values
        $update = [];
        $update['name'] = $request->input('name');
        $update['description'] = $request->input('description');

        $updated =  Provision::where($query)->update($update);
        if($updated){
            $this->clearProvision( $request->input('pt_id'), $request->input('id') );
            //--------------------------------------------
            // Add the neccessary assets to the provision
            $id = $request->input('id');
            $this->addAssetsToProvision( $id, $request );
        }
        return $updated;
    }


    /**
     * [addAssetsToProvision description]
     * @param [type] $id      [description]
     * @param [type] $request [description]
     */
    private function addAssetsToProvision( $id, $request ) {
        // $resources = $request->input('resources');
        // $this->addResourcesToProvision( $id, $resources );

        $needs = $request->input('allocated_needs');
        $this->addNeedsToProvision( $id, $needs );

        $students = $request->input('allocated_students');
        $this->addStudentsToProvision( $id, $students );

        $classes = $request->input('allocated_classes');
        $this->addClassesToProvision( $id, $classes );

        $groups = $request->input('allocated_groups');
        $this->addVulnerableGroupsToProvision( $id, $groups );

        $staff = $request->input('allocated_staff');
        $this->addStaffToProvision( $id, $staff );

        $times = $request->input('allocated_times');
        $this->addTimesToProvision( $id, $times );

        $digital_resources = $request->input('allocated_digital_resources');
        $this->addDigitalResourcesToProvision( $id, $digital_resources );

        $physical_resources = $request->input('allocated_physical_resources');
        $this->addPhysicalResourcesToProvision( $id, $physical_resources );

        $locations = $request->input('allocated_locations');
        $this->addLocationsToProvision( $id, $locations );

        $external_providers = $request->input('allocated_external_providers');
        $this->addExternalProvidersToProvision( $id, $external_providers );

        $human_resources = $request->input('allocated_human_resources');
        $this->addHumanResourcesToProvision( $id, $human_resources );
    }

    /**
     * [addDigitalResourceToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addDigitalResourcesToProvision( $id, $items ) {
        if(count($items) > 0){
            foreach($items as $item){
                $resource = new ProvisionDigitalResource;
                $resource->provision_id = $id;
                $resource->digital_resource_id = $item;
                $resource->save();
            }
        }
    }

    /**
     * [addPhysicalResourceToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addPhysicalResourcesToProvision( $id, $items ) {
        if(count($items) > 0){
            foreach($items as $item){
                $resource = new ProvisionPhysicalResource;
                $resource->provision_id = $id;
                $resource->physical_resource_id = $item;
                $resource->save();
            }
        }
    }

    /**
     * [addLocationsToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addLocationsToProvision( $id, $items ) {
        if(count($items) > 0){
            foreach($items as $item){
                $resource = new ProvisionLocation;
                $resource->provision_id = $id;
                $resource->location_id = $item;
                $resource->save();
            }
        }
    }

    /**
     * [addExternalProvidersToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addExternalProvidersToProvision( $id, $items ) {
        if(count($items) > 0){
            foreach($items as $item){
                $resource = new ProvisionExternalProvider;
                $resource->provision_id = $id;
                $resource->external_provider_id = $item;
                $resource->save();
            }
        }
    }

    /**
     * [addResourcesToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addHumanResourcesToProvision( $id, $items ) {
        if(count($items) > 0){
            foreach($items as $item){
                $resource = new ProvisionHumanResource;
                $resource->provision_id = $id;
                $resource->human_resource_id = $item;
                $resource->save();
            }
        }
    }

    /**
     * [addNeedsToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addNeedsToProvision( $id, $items ) {
        if(count($items)>0){
            foreach($items as $item){
                $need = new ProvisionsAreaOfNeed;
                $need->provision_id = $id;
                $need->area_of_need_id = $item;
                $need->save();
            }
        }
    }

    /**
     * [addStudentsToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addStudentsToProvision( $id, $items ) {
        if(count($items)>0){
            foreach($items as $item){
                $student = new ProvisionStudents;
                $student->provision_id = $id;
                $student->student_id = $item;
                $student->save();
            }
        }
    }

    /**
     * [addClassesToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addClassesToProvision( $id, $items ) {
        if(count($items)>0){
            foreach($items as $item){
                $class = new ProvisionClasses;
                $class->provision_id = $id;
                $class->class_id = $item;
                $class->save();
            }
        }
    }

    /**
     * [addVulnerableGroupsToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addVulnerableGroupsToProvision( $id, $items ) {
        if(count($items)>0){
            foreach($items as $item){
                $v_group = new ProvisionVulnerableGroup;
                $v_group->provision_id = $id;
                $v_group->group_id = $item;
                $v_group->save();
            }
        }
    }

    /**
     * [addStaffToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addStaffToProvision( $id, $items ) {
        if(count($items)>0){
            foreach($items as $item){
                $teacher = new ProvisionStaff;
                $teacher->provision_id = $id;
                $teacher->staff_id = $item;
                $teacher->save();
            }
        }
    }

    /**
     * [addTimesToProvision description]
     * @param [type] $id    [description]
     * @param [type] $items [description]
     */
    private function addTimesToProvision( $id, $items ) {
        if(count($items)>0){
            foreach($items as $item){
                $time = new ProvisionTime();
                $time->provision_id = $id;
                $time->time_id = $item;
                $time->save();
            }
        }
    }

    /**
     * [clearProvision description]
     * @param  [type] $pt_id [description]
     * @param  [type] $id    [description]
     * @return [type]        [description]
     */
    private function clearProvision( $pt_id=null, $id=null ){
        // Delete Earlier Provision Resources,Area of need,classes,students,Groups,
        // to make it easier to update a provision
        $query = [];
        if( $id ) {
            $query[] = ['provision_id', $id];
        }
        ProvisionsAreaOfNeed::where($query)->delete();
        ProvisionStudents::where($query)->delete();
        ProvisionClasses::where($query)->delete();
        ProvisionVulnerableGroup::where($query)->delete();
        ProvisionStaff::where($query)->delete();
        ProvisionTime::where($query)->delete();
        ProvisionDigitalResource::where($query)->delete();
        ProvisionExternalProvider::where($query)->delete();
        ProvisionHumanResource::where($query)->delete();
        ProvisionLocation::where($query)->delete();
        ProvisionPhysicalResource::where($query)->delete();
    }

    /**
     * [deleteOrganisation description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function removeProvision($pt_id=null, $id=null) {
        $query = [];
        $query[] = ['pt_id', $pt_id];
        $this->clearProvision( $pt_id, $id );
        return Provision::where($query)->delete();
    }

    /**
     * [getOrganisation description]
     * @param  [type] $id   [description]
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getProvision($pt_id) {
        return Provision::where('pt_id','=',$pt_id)->first();
    }

    /**
     * [getProvisions description]
     * @param  [type] $org_id [description]
     * @return [type]             [description]
     */
    public function getProvisions( $org_id ) {
        $provisions = Provision::where('organisation_id', '=', $org_id)->get();
        return new Collection($provisions);
    }

    public function getAllocatedAreaOfNeeds( $provision_id=null ){
        $provison_area_of_need = DB::table('provision_areas_of_need')
            ->join('areas_of_need', 'provision_areas_of_need.area_of_need_id', '=', 'areas_of_need.id')
            ->select('areas_of_need.id', 'areas_of_need.name')
            ->where('provision_areas_of_need.provision_id', $provision_id)
            ->get();
        return $provison_area_of_need;
    }

    public function getAllocatedStudents( $provision_id=null ){
        $provision_students = DB::table('provision_students')
            ->join('students', 'provision_students.student_id', '=', 'students.id')
            ->select('students.id', 'students.first_name', 'students.last_name')
            ->where('provision_students.provision_id', $provision_id)
            ->get();
        return $provision_students;
    }

    public function getAllocatedClasses( $provision_id=null ){
        $provision_classes = DB::table('provision_classes')
            ->join('classes', 'provision_classes.class_id', '=', 'classes.id')
            ->select('classes.id', 'classes.class_name')
            ->where('provision_classes.provision_id', $provision_id)
            ->get();
        return $provision_classes;
    }

    public function getAllocatedVulnerableGroup( $provision_id=null ){
        $provision_vulnerable_group = DB::table('provision_vulnerable_groups')
            ->join('vulnerable_groups','vulnerable_groups.id','=','provision_vulnerable_groups.group_id')
            ->select('vulnerable_groups.id','vulnerable_groups.name')
            ->where('provision_vulnerable_groups.provision_id', $provision_id)
            ->get();
        return $provision_vulnerable_group;
    }

    public function getAllocatedStaff( $provision_id=null ){
        $provision_staff =  DB::table('provision_staff')
            ->join('staff','staff.id','=','provision_staff.staff_id')
            ->select('staff.id','staff.first_name','staff.last_name')
            ->where('provision_staff.provision_id',$provision_id)
            ->get();
        return $provision_staff;
    }

    /**
     * [getProvisionTimes description]
     * @return [type] [description]
     */
    public function getAllocatedTimes( $provision_id=null ) {
        $times =  DB::table('provision_times')
            ->join('time_slots','time_slots.id','=','provision_times.time_id')
            ->where('provision_times.provision_id',$provision_id)
            ->get();
        return $times;
    }

    /**
     * [getAllocatedDigitalResources description]
     * @param  [type] $provision_id [description]
     * @return [type]               [description]
     */
    public function getAllocatedDigitalResources( $provision_id ){
        $result =  DB::table('provision_digital_resources')
            ->join('resources','resources.id','=','provision_digital_resources.digital_resource_id')
            ->join('resources_type','resources_type.pt_id','=','resources.type')
            ->where('resources_type.name', 'Digital Resource')
            ->select('resources.name', 'resources.id')
            ->where('provision_digital_resources.provision_id', $provision_id)
            ->get();
        return $result;
    }

    /**
     * [getAllocatedPhysicalResources description]
     * @param  [type] $provision_id [description]
     * @return [type]               [description]
     */
    public function getAllocatedPhysicalResources( $provision_id ) {
        $result =  DB::table('provision_physical_resources')
            ->join('resources','resources.id','=','provision_physical_resources.physical_resource_id')
            ->join('resources_type','resources_type.pt_id','=','resources.type')
            ->where('resources_type.name', 'Physical Resource')
            ->select('resources.name', 'resources.id')
            ->where('provision_physical_resources.provision_id', $provision_id)
            ->get();
        return $result;
    }

    /**
     * [getAllocatedHumanResources description]
     * @param  [type] $provision_id [description]
     * @return [type]               [description]
     */
    public function getAllocatedHumanResources( $provision_id ) {
        $result =  DB::table('provision_human_resources')
            ->join('resources','resources.id','=','provision_human_resources.human_resource_id')
            ->join('resources_type','resources_type.pt_id','=','resources.type')
            ->where('resources_type.name', 'Human Resource')
            ->select('resources.name', 'resources.id')
            ->where('provision_human_resources.provision_id', $provision_id)
            ->get();
        return $result;
    }

    /**
     * [getAllocatedLocations description]
     * @param  [type] $provision_id [description]
     * @return [type]               [description]
     */
    public function getAllocatedLocations( $provision_id ) {
        $result =  DB::table('provision_locations')
            ->join('resources','resources.id','=','provision_locations.location_id')
            ->join('resources_type','resources_type.pt_id','=','resources.type')
            ->where('resources_type.name', 'Location')
            ->select('resources.name', 'resources.id')
            ->where('provision_locations.provision_id', $provision_id)
            ->get();
        return $result;
    }
     /**
     * [getAllocatedExternalProviders description]
     * @param  [type] $provision_id [description]
     * @return [type]               [description]
     */
    public function getAllocatedExternalProviders( $provision_id ) {
        $result =  DB::table('provision_external_providers')
            ->join('resources','resources.id','=','provision_external_providers.external_provider_id')
            ->join('resources_type','resources_type.pt_id','=','resources.type')
            ->where('resources_type.name', 'External Provider')
            ->select('resources.name', 'resources.id')
            ->where('provision_external_providers.provision_id', $provision_id)
            ->get();
        return $result;
    }
    /**
     * [getScheduleProvisions [description]
     * @param  [type] $org_id [description]
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    public function getScheduleProvisions( $org_id,$date ){
        // Fetting all provisions that runs for a date
        $provisions = DB::table('provisions')
            ->join('provision_times','provision_times.provision_id','=','provisions.id')
            ->join('time_slots','time_slots.id','=','provision_times.time_id')
            ->select('provisions.id','provisions.name','time_slots.start_date','time_slots.end_date','time_slots.start_time','time_slots.end_time','time_slots.repeating')
            ->where([ ['time_slots.start_date', '<=', $date], ['end_date', '>=', $date], ['provisions.organisation_id', '=',$org_id],])
            ->get();
        return $provisions;
    }

    public function checkProvisionRuns( $provisions,$date ){
        $data = array();
        $current_day_name = $date->format('l');  // get the day name 
        $current_day = $date->format('j'); // get the date number
        $current_month = $date->format('F'); // get currnet month
        $current_year = $date->format('Y');  // get current year
        foreach($provisions as $provision){
            
             $provision_start_date = Carbon::parse($provision->start_date);
             $provision_day_name = $provision_start_date->format('l'); // get the day name 
             $provision_day = $provision_start_date->format('j'); // get the date number
             $provision_month = $provision_start_date->format('F'); // get currnet month
             $provision_year = $provision_start_date->format('Y'); // get current year
            switch ($provision->repeating) { // check when provision Repeats

                case 'daily': // If it runs daily then we return provision dates
                    $data[] = array('name'=>$provision->name,'start_date'=>$provision->start_date,'end_date'=>$provision->end_date,'start_time'=>$provision->start_time,'end_time'=>$provision->end_time);
                    break;
                case 'weekly': // If Provision runs weekly then

                // Check If current day name is equal to the starting day name for provision.If equals then provision will run on date

                    if($provision_day_name == $current_day_name){ 

                        $data[] = array('name'=>$provision->name,'start_date'=>$provision->start_date,'end_date'=>$provision->end_date,'start_time'=>$provision->start_time,'end_time'=>$provision->end_time);
                    }
                    break;
                case 'monthly': // If provision runs monthly

                    // Checking If current day number and provision day number is equal
                    if($provision_day == $current_day ){
                        $data[] = array('name'=>$provision->name,'start_date'=>$provision->start_date,'end_date'=>$provision->end_date,'start_time'=>$provision->start_time,'end_time'=>$provision->end_time);
                    }

                    break;
                    case 'termly':
                    break;
                case 'yearly': // If it runs yearly

                    // Checking If current day number and provision day number is equal and provision number and current month are equal 

                    if($provision_day == $current_day && $provision_month == $current_month){
                        $data[] = array('name'=>$provision->name,'start_date'=>$provision->start_date,'end_date'=>$provision->end_date,'start_time'=>$provision->start_time,'end_time'=>$provision->end_time);
                    }

                    break;
                
                default: // If provision is not repeating
                
                    $data = array('name'=>$provision->name,'start_date'=>$provision->start_date,'end_date'=>$provision->end_date,'start_time'=>$provision->start_time,'end_time'=>$provision->end_time);
            } 
        }
        return $data;
    }
}
