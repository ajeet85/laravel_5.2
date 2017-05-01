<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use Illuminate\Pagination\Paginator;

class GroupService implements GroupServiceInterface
{
    public function __construct( UniqueIdServiceInterface $idService) {
        $this->idService = $idService;
        $this->max_no_of_records_per_page = 15;
    }
    /**
     * [GetGroups description]
     * @param  [type] $org_id               [description]
     * @return [type]             [description]
     */
    public function getGroups($org_id=null){
        $query = [];
        if( $org_id ) {

            $query[] = ['organisation_id', $org_id];
        }

        return Group::where($query)->paginate($this->max_no_of_records_per_page);
    }
    /**
     * [GetGroup description]
     * @param  [type] $pt_id               [description]
     * @return [type]             [description]
     */
    public function getGroup( $org_id,$pt_id=null,$name=null ){
        $query = [];
        $query['organisation_id'] = $org_id;
        if( $pt_id ){
            $query['pt_id'] = $pt_id;
        }
        if( $name ){
            $query['name'] = $name;
        }
        return Group::where($query)->first();
    }
     /**
     * [createGroup description]
     * @param  [type] $org_id               [description]
     * @param  [type] $group_name           [description]
     * @param  [type] $group_description    [description]
     * @param  [type] $slug                 [description]
     *
     * @return [type]             [description]
     */
    public function createGroup($org_id,$group_name,$group_description,$slug){
            $pt_id = $this->idService->ptid();
            $group = new Group;
            $group->pt_id = $pt_id;
            $group->organisation_id = $org_id;
            $group->name = $group_name;
            $group->description = $group_description;
            $group->slug = $slug;
            $created = $group->save();
            return $created;
    }
    /**
     * [createGroup description]
     * @param  [type] $pt_id               [description]
     * @param  [type] $org_id               [description]
     * @param  [type] $group_name           [description]
     * @param  [type] $group_description    [description]
     * @param  [type] $slug                 [description]
     *
     * @return [type]             [description]
     */
    public function updateGroup($pt_id,$org_id,$group_name,$group_description,$slug){
        $updated = Group::where('pt_id','=',$pt_id)->update(['organisation_id' => $org_id,'name' => $group_name,'description' => $group_description,'slug' => $slug]);
         return $updated;
    }

    public function removeGroup($org_id, $id=null, $pt_id=null){
        $query = [];
        $query['organisation_id'] = $org_id;

        if( $id ) {
            $query[] = ['id', $id];
        }
        if( $pt_id ) {
            $query[] = ['pt_id', $pt_id];
        }
        $deletedRows = Group::where($query)->delete();
        return $deletedRows;
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
                    $check_group = $this->getGroup($org_id,null,$row->name);
                    if(!$check_group){
                        \DB::table('vulnerable_groups')->insert([
                            'organisation_id' => $org_id,
                            'pt_id' => $idService->ptId(),
                            'name' => $row->name,
                            'description' => $row->description,
                            'slug' => str_slug($row->name, '-'),
                            'created_at' => new \Carbon\Carbon(),
                            'updated_at' => new \Carbon\Carbon(),
                        ]);    
                    }
                    
                });
            }

        });
        return true;
    }

}
