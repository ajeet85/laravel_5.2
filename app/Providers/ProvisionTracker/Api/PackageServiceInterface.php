<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\Package;
use App\Models\PackageGroup;

interface PackageServiceInterface
{
    // get package group
    // get package from group
    public function getPackagesAsCluster();
    public function getPackageGroup( $id );
    public function getPackageGroups( );
    public function getPackages( PackageGroup $group=null );
    public function getPackagesAsOptions( PackageGroup $group=null );
    public function getPackage( $id=null, $static_id=null );
    public function getPackageFees( $total_invoices=null );
}
