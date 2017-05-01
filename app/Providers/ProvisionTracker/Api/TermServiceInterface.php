<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Term;

interface TermServiceInterface
{
    public function getTerms( $org_id );
    public function getTerm( $org_id, $id=null, $pt_id=null, $name=null );
    public function addTerm( $org_id, $term );
    public function updateTerm( $id=null, $pt_id=null, $data );
    public function removeTerm( $org_id, $id=null, $pt_id=null );
    public function importDefault( $org_id,$file_path );
}
