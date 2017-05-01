<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use Illuminate\Pagination\Paginator;

class OrganisationService implements OrganisationServiceInterface
{
    public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
        $this->max_no_of_records_per_page = 5;
    }

    /**
     * [createOrganisation description]
     * @param  [type] $org_id     [description]
     * @param  [type] $name       [description]
     * @param  [type] $address    [description]
     * @param  [type] $account_id [description]
     * @param  [type] $type_id    [description]
     * @return [type]             [description]
     */
    public function createOrganisation( $org_id, $name, $address, $account_id, $type_id ) {
        $org = factory(Organisation::class)->make([
            'pt_id'                => $this->idService->ptId(),
            'organisation_id'      => $org_id,
            'name'                 => $name,
            'address'              => $address,
            'slug'                 => str_slug($name, '-'),
            'account_id'           => $account_id,
            'type_id'              => $type_id
        ]);
        $saved = $org->save();
        return $saved;
    }

    /**
     * [setAccess description]
     * @param [type] $org_id [description]
     * @param [type] $level  [description]
     */
    public function setAccess($org_id, $level) {
        $organisation = $this->getOrganisation(null, null, $org_id);
        $organisation->access = $level;
        $access_set = $organisation->save();
        return $access_set;
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
    public function updateOrganisation( $id, $org_id, $name, $address, $type_id ) {
        $org = $this->getOrganisation( $id );
        $org->organisation_id = $org_id;
        $org->name = $name;
        $org->address = $address;
        $org->slug = str_slug($name, '-');
        $org->type_id = $type_id;
        $saved = $org->save();
        return $saved;
    }

    /**
     * [deleteOrganisation description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function removeOrganisation ($id) {
        $query = [];
        $query[] = ['id', $id];
        return Organisation::where($query)->delete();
    }

    /**
     * [getOrganisation description]
     * @param  [type] $id   [description]
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getOrganisation( $id=null, $slug=null, $org_id=null ) {
        $query = [];
        if( $id ) {
            $query[] = ['id', $id];
        }

        if( $slug ) {
            $query[] = ['slug', $slug];
        }

        if( $org_id ) {
            $query[] = ['organisation_id', $org_id];
        }
        return Organisation::where($query)->get()->first();
    }

    /**
     * [getOrganisations description]
     * @param  [type] $account_id [description]
     * @return [type]             [description]
     */
    public function getOrganisations( $account_id, $term=null ) {
        $query = [];
        $query[] = ['account_id', $account_id];

        if( $term ) {
            $query[] = ['name', 'like', "%$term%"];
        }
        return Organisation::where($query)->paginate($this->max_no_of_records_per_page);
    }

    /**
     * [getOrganisationsAsOptions description]
     * @param  [type] $account_id [description]
     * @return [type]             [description]
     */
    public function getOrganisationsAsOptions( $account_id ) {
        $orgs = $this->getOrganisations( $account_id );
        $options = [];
        foreach ($orgs as $org ) {
            $option = new \stdClass();
            $option->value = $org->id;
            $option->name = $org->name;
            $options[] = $option;
        }
        return $options;
    }

    /**
     * [getTypes description]
     * @return [type] [description]
     */
    public function getTypes( $id=null, $slug=null ) {
        $query = [];
        if( $id ) {
            $query[] = ['id', $id];
        }

        if( $slug ) {
            $query[] = ['slug', $slug];
        }

        $types = \DB::table('organisation_types')->where($query)->get();
        return new Collection($types);
    }

    /**
     * [getTypesAsOptions description]
     * @return [type] [description]
     */
    public function getTypesAsOptions() {
        $types = $this->getTypes();
        $options = [];
        // Add instuctions to the list
        $option = new \stdClass();
        $option->value = -1;
        $option->name = 'Choose an Organisation type';
        $options[] = $option;

        foreach ($types as $type ) {
            $option = new \stdClass();
            $option->value = $type->id;
            $option->name = $type->label;
            $options[] = $option;
        }
        return $options;
    }
}
