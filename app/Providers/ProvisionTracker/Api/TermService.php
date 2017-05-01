<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Models\Term;

class TermService implements TermServiceInterface
{
    public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
    }

    /**
     * [getTerms description]
     * @param  [type] $org_id [description]
     * @return [type]         [description]
     */
    public function getTerms( $org_id ) {
        $query = [];
        $query[] = ['organisation_id', $org_id];
        return Term::where($query)->paginate();
    }

    public function getTerm(  $org_id, $id=null, $pt_id=null, $name=null  ) {
        $query = [];
        $query[] = ['organisation_id',$org_id];
        if( $id ){
            $query[] = ['id', $id];
        }
        if( $pt_id ){
            $query[] = ['pt_id', $pt_id];
        }
        if( $name ){
            $query[] = ['name', $name];
        }
        return Term::where($query)->get()->first();
    }

    /**
     * [updateTerm description]
     * @param  [type] $id    [description]
     * @param  [type] $pt_id [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function updateTerm( $id=null, $pt_id=null, $data ) {
        $term = $this->getTerm($id, $pt_id);
        $values = $this->translateRequestValues($data);
        $term->update($values);
        return $term;
    }

    /**
     * [addTerm description]
     * @param [type] $org_id [description]
     * @param [type] $term   [description]
     */
    public function addTerm( $org_id, $term ) {
        $item = $this->translateRequestValues($term);
        $item['organisation_id'] = $org_id;
        $inserted = Term::create($item);
        return $inserted;
    }

    private function translateRequestValues( $term ) {
        $item['pt_id'] = $this->idService->ptId();
        $item['name'] = $term->input('term_name');
        $item['slug'] = str_slug($term->input('term_name'), '-');
        $item['start_date'] = new \Carbon\Carbon($term->input('start_date'));
        $item['end_date'] = new \Carbon\Carbon($term->input('end_date'));
        return $item;
    }
    /**
     * [removeTerm description]
     * @param  [type] $org_id [description]
     * @param  [type] $id     [description]
     * @param  [type] $pt_id  [description]
     * @return [type]         [description]
     */
    public function removeTerm( $org_id, $id=null, $pt_id=null  ){
        $query = [];
        $query['organisation_id'] = $org_id;

        if( $id ) {
            $query[] = ['id', $id];
        }
        if( $pt_id ) {
            $query[] = ['pt_id', $pt_id];
        }
        return Term::where($query)->delete();
    }

    /**
     * [importDefault description]
     * @param  [type] $org_id [description]
     * @return [type]         [description]
     */
    public function importDefault( $org_id,$file_path ) {
        // Remove all terms first
        
        $idService = $this->idService;
        \Excel::load($file_path, function($reader) use ($org_id, $idService) {
            foreach($reader->get() as $sheet) {
                $sheet->each(function( $row ) use ($org_id, $idService) {
                    $check_term = $this->getTerm( $org_id, null, null, $row->name );
                    if(!$check_term){
                        \DB::table('terms')->insert([
                            'organisation_id' => $org_id,
                            'pt_id' => $idService->ptId(),
                            'name' => $row->name,
                            'usage' => $row->usage,
                            'slug' => str_slug($row->name, '-'),
                            'start_date' => new \Carbon\Carbon($row->start),
                            'end_date' => new \Carbon\Carbon($row->end),
                        ]);    
                    }
                    
                });
            }
        });
        return true;
    }
}
