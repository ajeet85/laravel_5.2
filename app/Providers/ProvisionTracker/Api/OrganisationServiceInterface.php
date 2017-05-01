<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Organisation;

interface OrganisationServiceInterface
{
    public function createOrganisation( $org_id, $name, $address, $account_id, $type_id );
    public function updateOrganisation( $id, $org_id, $name, $address, $type_id );
    public function removeOrganisation ($id);
    public function getOrganisations( $account_id, $term=null );
    public function getOrganisationsAsOptions( $account_id );
    public function getOrganisation( $id=null, $slug=null, $org_id=null );
    public function getTypes( $id=null, $slug=null );
    public function getTypesAsOptions();
    public function setAccess($org_id, $level);
}
