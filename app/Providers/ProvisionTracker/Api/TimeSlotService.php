<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Models\TimeSlot;
use Carbon\Carbon;

class TimeSlotService implements TimeSlotServiceInterface
{
    public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
    }

    /**
     * [addTimeSlot description]
     * @param [type] $org_id  [description]
     * @param [type] $request [description]
     */
    public function addTimeSlot($org_id, $request) {
        $item = $this->translateRequestValues($request);
        $item['organisation_id'] = $org_id;
        $item['pt_id'] = $this->idService->ptId();
        $inserted = TimeSlot::create($item);
        return $inserted;
    }

    /**
     * [getTimeSlots description]
     * @param  [type] $org_id [description]
     * @return [type]         [description]
     */
    public function getTimeSlots( $org_id ) {
        $query = [];
        $query[] = ['organisation_id', $org_id];
        return TimeSlot::where($query);
    }

    /**
     * [getTimeSlot description]
     * @param  [type] $org_id [description]
     * @param  [type] $id     [description]
     * @param  [type] $pt_id  [description]
     * @return [type]         [description]
     */
    public function getTimeSlot( $org_id, $id=null, $pt_id=null ) {
        $query = [];
        $query[] = ['organisation_id', $org_id];
        if( $id ){
            $query[] = ['id', $id];
        }
        if( $pt_id ){
            $query[] = ['pt_id', $pt_id];
        }
        return TimeSlot::where($query)->get()->first();
    }

    /**
     * [updateTimeSlot description]
     * @param  [type] $org_id [description]
     * @param  [type] $id     [description]
     * @param  [type] $pt_id  [description]
     * @return [type]         [description]
     */
    public function updateTimeSlot($org_id, $id=null, $pt_id=null, $data) {
        $time_slot = $this->getTimeSlot($org_id, $id, $pt_id);
        $values = $this->translateRequestValues($data);
        $time_slot->update($values);
        return $time_slot;
    }

    /**
     * [removeTimeSlot description]
     * @param  [type] $org_id [description]
     * @param  [type] $id     [description]
     * @param  [type] $pt_id  [description]
     * @return [type]         [description]
     */
    public function removeTimeSlot($org_id, $id=null, $pt_id=null) {
        $query = [];
        $query['organisation_id'] = $org_id;

        if( $id ) {
            $query[] = ['id', $id];
        }
        if( $pt_id ) {
            $query[] = ['pt_id', $pt_id];
        }
        return TimeSlot::where($query)->delete();
    }

    /**
     * [translateRequestValues description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    private function translateRequestValues( $request ) {
        $item['name'] = $request->input('name');
        $item['start_date'] = new Carbon($request->input('start_date'));
        $item['end_date'] =  new  Carbon(($request->input('end_date')!='' ? $request->input('end_date') :  $request->input('start_date')));
        $item['start_time'] =  Carbon::parse($request->input('start_time'))->toTimeString();
        echo  $item['start_time'];
        
        $item['end_time'] = Carbon::parse($request->input('end_time'))->toTimeString();
        $item['repeating'] = $request->input('repeat', 'no');

        return $item;
    }
}
