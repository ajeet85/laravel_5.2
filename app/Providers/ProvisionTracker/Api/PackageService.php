<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\PackageGroup;
use App\Models\Package;

class PackageService implements PackageServiceInterface
{
    /**
     * [getPackagesAsCluster description]
     * @return [type] [description]
     */
    public function getPackagesAsCluster() {
        $packageGroups = $this->getPackageGroups();
        $groups = [];
        foreach ($packageGroups as $group ) {
            $id = $group->id;
            $groups[ $id ] = $group;
            $groups[ $id ]['packages'] = $this->getPackages( $group );
        }
        return $groups;
    }

    /**
     * [getPackageGroups description]
     * @return [type] [description]
     */
    public function getPackageGroups( ) {
        return PackageGroup::all();
    }

    /**
     * [getPackageGroup description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getPackageGroup( $id ) {
        $query = [];
        $query[] = ['id', $id];
        return PackageGroup::where( $query )->get()->first();
    }

    /**
     * [getPackages description]
     * @param  PackageGroup $group [description]
     * @return [type]              [description]
     */
    public function getPackages( PackageGroup $group=null ) {
        $query = [];
        if( $group ) {
            $query[] = ['package_group_id', $group->id];
        }

        return Package::where( $query )->get();
    }

    /**
     * [getPackageFees description]
     * @param  [type] $schedule [description]
     * @return [type]           [description]
     */
    public function getPackageFees( $schedule=null ) {
        $query = [];
        if( $schedule ) {
            $query[] = ['schedule', $schedule];
        }
        return \DB::table('package_cost_structure')->where($query)->get();
    }

    /**
     * [getPackagesAsOptions description]
     * @param  [type] $account_id [description]
     * @return [type]             [description]
     */
    public function getPackagesAsOptions( PackageGroup $group=null ) {
        $packages = $this->getPackages( $group );
        $options = [];
        foreach ($packages as $package ) {
            $option = new \stdClass();
            $option->value = $package->static_id;
            $option->name = $package->label;
            $options[] = $option;
        }
        return $options;
    }

    /**
     * [getPackage description]
     * @param  [type]       $id    [description]
     * @param  PackageGroup $group [description]
     * @return [type]              [description]
     */
    public function getPackage( $id=null, $static_id=null ) {
        $query = [];

        if( $id ) {
            $query[] = ['id', $id];
        }
        if( $static_id ) {
            $query[] = ['static_id', $static_id];
        }
        return Package::where( $query )->get()->first();
    }
}
