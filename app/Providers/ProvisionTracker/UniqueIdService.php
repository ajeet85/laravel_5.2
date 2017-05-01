<?php

namespace App\Providers\ProvisionTracker;
use Hashids\Hashids;

class UniqueIdService implements UniqueIdServiceInterface
{
    /**
     * [__construct description]
     */
    public function __construct( ) {
        $this->hashids = new Hashids('provisiontracker');
    }

    /**
     * [ptId description]
     * @return [type] [description]
     */
    public function ptId() {
        return $this->hashids->encode( rand(1,99), rand(1,99), rand(1,99), rand(1,99) );
    }

    /**
     * [uuId description]
     * @return [type] [description]
     */
    public function uuId() {

    }
}
