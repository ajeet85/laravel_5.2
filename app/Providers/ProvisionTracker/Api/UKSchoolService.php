<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\UKSchool;
use Illuminate\Database\Eloquent\Collection;

class UKSchoolService implements UKSchoolServiceInterface
{
    public function __construct( ) {

    }

    /**
     * [getSchool description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function getSchool( $request=null, $dfe_number=null ) {
        $query = [];
        if( $request ) {
            if( $request->has('postcode') ) {
                $query[] = ['postcode', $request->input('postcode')];
            }

            if( $request->has('dfe_number') ) {
                $query[] = ['dfe', $request->input('dfe_number')];
            }

            if( $request->has('name') ) {
                $name = $request->input('name');
                $query[] = ['name', 'like', "%$name%"];
            }
        }

        if( $dfe_number ) {
            $query[] = ['dfe', $dfe_number];
        }

        if( count($query) > 0 ){
            return UKSchool::where($query);
        }
        else {
            return new Collection();
        }
    }

    /**
     * [claimSchool description]
     * @param  [type] $dfe_number [description]
     * @return [type]             [description]
     */
    public function claimSchool( $dfe_number, $pt_id ) {
        $school = $this->getSchool(null, $dfe_number )->get()->first();
        $school->claimed = 'yes';
        $school->claimed_by = $pt_id;
        return $school->save();
    }

    /**
     * [unClaimSchool description]
     * @param  [type] $dfe_number [description]
     * @return [type]             [description]
     */
    public function unClaimSchool( $dfe_number ) {
        $school = $this->getSchool(null, $dfe_number)->get()->first();
        $school->claimed = 'no';
        return $school->save();
    }
}
