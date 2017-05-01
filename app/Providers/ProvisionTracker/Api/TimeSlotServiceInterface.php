<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\TimeSlot;

interface TimeSlotServiceInterface
{
    public function getTimeSlots( $org_id );
    public function getTimeSlot( $org_id, $id=null, $pt_id=null );
    public function addTimeSlot($org_id, $request);
    public function updateTimeSlot($org_id, $id=null, $pt_id=null, $request);
    public function removeTimeSlot($org_id, $id=null, $pt_id=null);
}
