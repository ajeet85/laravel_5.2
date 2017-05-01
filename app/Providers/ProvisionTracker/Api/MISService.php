<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\MISProvider;
use App\Models\MIS;
use App\Models\MISSchoolService;

class MISService implements MISServiceInterface
{
    public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
    }

    public function getProvider($id=null, $name=null, $slug=null) {
        $query = [];
        if( $id ) {
            $query[] = ['id', $id];
        }
        if( $name ) {
            $query[] = ['name', $name];
        }
        if( $slug ) {
            $query[] = ['slug', $slug];
        }
        return MISProvider::where($query)->get()->first();
    }

    public function getSchoolService( $school_id ) {
        $query = [];
        $query[] = ['school_id', $school_id];
        return MISSchoolService::where($query)->get()->first();
    }

    public function getMISProviders() {
        return MISProvider::all();
    }

    public function getMISService($id=null) {
        $query = [];
        if( $id ) {
            $query[] = ['id', $id];
        }
        return MIS::where($query)->get()->first();
    }

    public function getMISServices() {
        $services = \DB::table('mis_services')
                    ->join('mis_providers', 'mis_services.provider_id', '=', 'mis_providers.id')
                    ->select('mis_services.*', 'mis_providers.name as provider_name', 'mis_providers.id as provider_id')
                    ->get();
        return new Collection( $services );
    }

    public function updateService( $id, $data) {
        $service = MISSchoolService::firstOrNew( $data );
        $service->password  = \Hash::make( $data['password'] );
        $service->pt_id = $this->idService->ptId();
        $service->save();
    }
}
