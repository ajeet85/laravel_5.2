<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Providers\ProvisionTracker\Api\PackageService;
use Illuminate\Database\Eloquent\Collection;
use App\Models\PackageGroup;
use App\Models\Package;

class PackageServiceTest extends TestCase
{
    public function __construct() {
        $this->packageService = new PackageService();
    }

    /**
     * [testGetPackageGroups description]
     * @return [type] [description]
     */
    public function testGetPackageGroups() {
        // Packages should be seeded by the database.
        // They are not user generated and should always
        // be present. Their ids should always start from 1.
        // Currently we have 3 packages
        $pkgG_1 = $this->packageService->getPackageGroup(1);
        $pkgG_2 = $this->packageService->getPackageGroup(2);
        $pkgG_3 = $this->packageService->getPackageGroup(3);
        $this->assertNotNull($pkgG_1);
        $this->assertNotNull($pkgG_2);
        $this->assertNotNull($pkgG_3);
        $this->assertInstanceOf( PackageGroup::class, $pkgG_1);
        $this->assertInstanceOf( PackageGroup::class, $pkgG_2);
        $this->assertInstanceOf( PackageGroup::class, $pkgG_3);
    }

    /**
     * [testPackages description]
     * @return [type] [description]
     */
    public function testPackages() {
        // Right now we have 4 packages assigned
        // to different package groups.
        // Check for these.
        $pkg_1 = $this->packageService->getPackage(1);
        $pkg_2 = $this->packageService->getPackage(2);
        $pkg_3 = $this->packageService->getPackage(3);
        $pkg_4 = $this->packageService->getPackage(4);
        $this->assertNotNull($pkg_1);
        $this->assertNotNull($pkg_2);
        $this->assertNotNull($pkg_3);
        $this->assertNotNull($pkg_4);
        $this->assertInstanceOf( Package::class, $pkg_1);
        $this->assertInstanceOf( Package::class, $pkg_2);
        $this->assertInstanceOf( Package::class, $pkg_3);
        $this->assertInstanceOf( Package::class, $pkg_4);
    }

    /**
     * [testPackagesFromGroup description]
     * @return [type] [description]
     */
    public function testPackagesFromGroup() {
        $pkgG_1 = $this->packageService->getPackageGroup(1);
        $pkgG_2 = $this->packageService->getPackageGroup(2);
        $pkgG_3 = $this->packageService->getPackageGroup(3);
        $pkgs_G1 = $this->packageService->getPackages($pkgG_1);
        $pkgs_G2 = $this->packageService->getPackages($pkgG_2);
        $pkgs_G3 = $this->packageService->getPackages($pkgG_3);
        $this->assertInstanceOf( Collection::class, $pkgs_G1);
        $this->assertInstanceOf( Collection::class, $pkgs_G2);
        $this->assertInstanceOf( Collection::class, $pkgs_G3);
    }

    /**
     * [testGetAllPackageGroups description]
     * @return [type] [description]
     */
    public function testGetAllPackageGroups() {
        $allGroups = $this->packageService->getPackageGroups();
        $this->assertInstanceOf( Collection::class, $allGroups);
        $this->assertEquals(count($allGroups), 3);
    }

    /**
     * [testPackageCluster description]
     * @return [type] [description]
     */
    public function testPackageCluster() {
        $cluster = $this->packageService->getPackagesAsCluster();
        $this->assertEquals(count($cluster), 3);
        $groups = [];
        foreach ($cluster as $group ) {
            $id = $group->id;
            $groups[ $id ] = $group;
            $this->assertInstanceOf( Collection::class, $groups[ $id ]['packages']);
        }
    }
}
