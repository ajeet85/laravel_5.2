<?php

namespace App\Providers\ProvisionTracker\Api;

use App\Models\Resource;
use App\Models\ResourceType;
use Illuminate\Database\Eloquent\Collection;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use Illuminate\Pagination\Paginator;
use DB;

Class ResourceService Implements ResourceServiceInterface{

	public function __construct( UniqueIdServiceInterface $idService ){
		 $this->idService = $idService;
         $this->max_no_of_records_per_page = 2;
	}
	 /**
     * [getResourceTypeA description]
     *
     * @return [type]             [description]
     */
	public function getResourceType( $id=null, $slug=null ){
        $query = [];
        if( $id ) {
            $query[] = ['id', $id];
        }
        if( $slug ) {
            $query[] = ['slug', $slug];
        }
		return ResourceType::where($query)->get()->first();
	}
	/**
     * [getResourceForOrganisation description]
     * @param  [type] $org_id [description]
     * @return [type]             [description]
     */
	public function getResources($org_id, $type_id=null){
        $query = [];
        $query[] = ['organisation_id', $org_id];
        if( $type_id ) {
            $query[] = ['type', $type_id];
        }
        return Resource::where($query)->paginate($this->max_no_of_records_per_page);
	}
	/**
     * [getParticularResource description]
     * @param  [type] $pt_id [description]
     * @return [type]             [description]
     */
	public function getResource($pt_id){
        $query = [];
        $query[] = ['pt_id', $pt_id];
        return Resource::where($query)->get()->first();
	}
	 /**
     * [getResourceTypeAsOptions description]
     *
     * @return [type]             [description]
     */
	public function getResouceTypeAsOptions() {
        $resources = ResourceType::All();
        $options = [];
        foreach ($resources as $type ) {
            $option = new \stdClass();
            $option->value = $type->pt_id;
            $option->name = $type->name;
            $option->slug = $type->slug;
            $options[] = $option;
        }
        return $options;
    }
    /**
     * [AddResource description]
     * @param  [type] $resource_name [description]
     * @param  [type] $resource_cost [description]
     * @param  [type] $resource_type_id [description]
     * @param  [type] $organisation_id [description]
     * @return [type]             [description]
     */
    public function createResource($resource_name,$resource_cost,$resource_type_id,$organisation_id){
    	$pt_id = $this->idService->ptId();
		$resource = new Resource;
		$resource->pt_id = $pt_id;
		$resource->organisation_id = $organisation_id;
		$resource->name = $resource_name;
		$resource->cost = $resource_cost;
		$resource->slug = str_slug($resource_name,'-');
		$resource->type = $resource_type_id;

		$created = $resource->save();
		return $created;
    }
    /**
     * [UpdateResource description]
	 * @param  [type] $pt_id [description]
     * @param  [type] $resource_name [description]
     * @param  [type] $resource_cost [description]
     * @param  [type] $resource_type_id [description]
     * @param  [type] $organisation_id [description]
     * @return [type]             [description]
     */
    public function updateResource($pt_id,$resource_name,$resource_cost,$resource_type_id,$organisation_id){
    	$resource_slug = str_slug($resource_name);

    	$updated = Resource::where('pt_id','=',$pt_id)->update(['name'=>$resource_name,'cost'=>$resource_cost,'type'=>$resource_type_id,'slug'=>$resource_slug,'organisation_id'=>$organisation_id]);
    	return $updated;
    }
    /**
     * [DeleteResource description]
	 * @param  [type] $pt_id [description]
     * @return [type]             [description]
     */
    public function deleteResource($pt_id){
    	return Resource::where('pt_id','=',$pt_id)->delete();
    }

    /**
     * [getResourceForOrganisation description]
     * @param  [type] $org_id [description]
     * @return [type]             [description]
     */
    public function getAllResources($org_id, $type_id=null){
        $query = [];
        $query[] = ['organisation_id', $org_id];
        if( $type_id ) {
            $query[] = ['type', $type_id];
        }
        $resources = DB::table('resources')
            ->leftJoin('resources_type', 'resources.type', '=', 'resources_type.pt_id')
            ->select('resources.pt_id','resources.name','resources_type.name as resources_type_name','resources_type.slug as resource_type','resources_type.pt_id as resource_type_id')
            ->where($query)
            ->get();
        return $resources;
    }

}
?>
