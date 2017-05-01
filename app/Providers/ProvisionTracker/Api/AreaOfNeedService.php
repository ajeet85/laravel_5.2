<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Models\AreaOfNeed;
use Illuminate\Pagination\Paginator;
use DB;

Class AreaOfNeedService implements AreaOfNeedServiceInterface{

	public function __construct( UniqueIdServiceInterface $idService ){
		 $this->idService = $idService;
		 $this->max_no_of_records_per_page = 5;
	}

    /**
     * [getSubAreaOfNeed description]
     * @param  [type] $org_id    [description]
     * @param  [type] $parent_id [description]
     * @return [type]            [description]
     */
	private function getSubAreaOfNeed($org_id, $parent_id, $as_options=false)
	{
        $needs = $this->getChildNeeds( $org_id, $parent_id );
        foreach($needs as $need) {
            $need->children = $this->getSubAreaOfNeed($org_id, $need->id, $as_options );
        }
        if( $as_options ){
            $options = $needs->map(function($item, $key){
                $option = new \stdClass();
                $option->value = $item->id;
                $option->pt_id = $item->pt_id;
                $option->name = $item->name;
                return $option;
            });
            foreach($options as $option) {
                $option->children = $this->getSubAreaOfNeed($org_id, $option->value, $as_options );
            }
        }

        return ($as_options) ? $options : $needs;
	}

    /**
     * [getChildNeeds description]
     * @param  [type] $org_id    [description]
     * @param  [type] $parent_id [description]
     * @return [type]            [description]
     */
    private function getChildNeeds( $org_id, $parent_id ) {
        $query = [];
        $query[] = ['parent_id', $parent_id];
        $needs = AreaOfNeed::where($query)
                 ->where(function($q) use($org_id){
                     $q->where('organisation_id', $org_id)
                       ->orWhere('organisation_id', null);
                 })->get();
        return new Collection($needs);
    }

    /**
     * [getAreaOfNeeds description]
     * @param  [type] $org_id [description]
     * @return [type]         [description]
     */
	public function getAreaOfNeeds($org_id) {
        // Get base needs first
        // Then build a recursive list of the child needs
        return $this->getSubAreaOfNeed($org_id, null);
	}

    public function getNeedsAsOptions( $org_id ) {
        // Get base needs first
        // Then build a recursive list of the child needs
        return $this->getSubAreaOfNeed($org_id, null, true);
    }

    /**
     * [createAreaOfNeed description]
     * @param  [type] $organisation_id          [description]
     * @param  [type] $area_of_need_name        [description]
     * @param  [type] $area_of_need_description [description]
     * @param  [type] $parent_id                [description]
     * @return [type]                           [description]
     */
	public function createAreaOfNeed($organisation_id,$area_of_need_name,$area_of_need_description,$parent_id){
		$pt_id = $this->idService->ptId();
		$area_of_need = new AreaOfNeed;
		$area_of_need->pt_id = $pt_id;
		$area_of_need->organisation_id = $organisation_id;
		$area_of_need->name = $area_of_need_name;
		$area_of_need->description = $area_of_need_description;
		$area_of_need->slug = str_slug($area_of_need_name,'-');
		$area_of_need->parent_id = $parent_id;
		$created = $area_of_need->save();
		return $created;
	}

    /**
     * [getAreaOfNeed description]
     * @param  [type] $pt_id [description]
     * @return [type]        [description]
     */
	public function getAreaOfNeed( $org_id,$pt_id=null,$name=null ){
        $query = [];
        $query['organisation_id'] = $org_id;
        if($pt_id){
            $query['pt_id'] = $pt_id;
        }
        if($name){
            $query['name'] = $name;
        }
		return AreaOfNeed::where($query)->first();
	}

    /**
     * [updateAreaOfNeed description]
     * @param  [type] $pt_id                  [description]
     * @param  [type] $org_id                 [description]
     * @param  [type] $area_of_need_name      [description]
     * @param  [type] $areaofneed_description [description]
     * @return [type]                         [description]
     */
	public function updateAreaOfNeed($pt_id,$org_id,$area_of_need_name,$areaofneed_description){
		$slug = str_slug($area_of_need_name);
		$affectedrows = AreaOfNeed::where('pt_id','=',$pt_id)->update(['organisation_id'=>$org_id,'name'=>$area_of_need_name,'description'=>$areaofneed_description,'slug'=>$slug]);
		return $affectedrows;
	}

    /**
     * [removeAreaOfNeed description]
     * @param  [type] $org_id [description]
     * @param  [type] $id     [description]
     * @param  [type] $pt_id  [description]
     * @return [type]        [description]
     */
	public function removeAreaOfNeed( $org_id, $id=null, $pt_id=null ){
        $query = [];
        $query['organisation_id'] = $org_id;

        if( $id ) {
            $query[] = ['id', $id];
        }
        if( $pt_id ) {
            $query[] = ['pt_id', $pt_id];
        }
		return AreaOfNeed::where($query)->delete();
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
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService,$org_id) {
                    $check_need = $this->getAreaOfNeed($org_id,null,$row->name);
                    if(!$check_need){
                         \DB::table('areas_of_need')->insert([
                            'pt_id' => $idService->ptId(),
                            'organisation_id' => $org_id,
                            'name' => $row->name,
                            'slug' => str_slug($row->name, '-'),
                            'description' => $row->description
                         ]);
                    }

                });
            }

            // Assign parents
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService,$org_id) {
                    $no_parent = DB::table('areas_of_need')->where(['name'=>'No Parent'])->first();
                    $parent = DB::table('areas_of_need')->where(['name'=>$row->parent,'organisation_id'=>$org_id])->first();
                    if( $parent ) {
                        DB::table('areas_of_need')
                            ->where('name', $row->name)
                            ->update(['parent_id'=>$parent->id]);
                    }
                    else {
                        DB::table('areas_of_need')
                            ->where('name', $row->name)
                            ->update(['parent_id'=>$no_parent->id]);
                    }
                });
            }
        });
        return true;
    }
}
