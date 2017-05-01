<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Only seed core data
        $needs_seeded =             DB::table('seeded')->where('is_seeded', '=', 'areas_of_need')->get();
        $permissions_seeded =       DB::table('seeded')->where('is_seeded', '=', 'permissions')->get();
        $mis_seeded =               DB::table('seeded')->where('is_seeded', '=', 'mis')->get();
        $packages_seeded =          DB::table('seeded')->where('is_seeded', '=', 'packages')->get();
        $resource_types_seeded =    DB::table('seeded')->where('is_seeded', '=', 'resource_types')->get();
        $user_types_seeded =        DB::table('seeded')->where('is_seeded', '=', 'user_types')->get();
        $org_types_seeded =         DB::table('seeded')->where('is_seeded', '=', 'org_types')->get();
        $schools_seeded =           DB::table('seeded')->where('is_seeded', '=', 'schools')->get();

        if( count($needs_seeded) < 1 ) {
            $this->call(AreasOfNeedSeeder::class);
            DB::table('seeded')->insert(['is_seeded' => 'areas_of_need']);
        }

        if( count($permissions_seeded) < 1 ) {
            $this->call(PermissionsSeeder::class);
            DB::table('seeded')->insert(['is_seeded' => 'permissions']);
        }

        if( count($mis_seeded) < 1 ) {
            $this->call(MISSeeder::class);
            DB::table('seeded')->insert(['is_seeded' => 'mis']);
        }

        if( count($packages_seeded) < 1 ) {
            $this->call(PackageSeeder::class);
            DB::table('seeded')->insert(['is_seeded' => 'packages']);
        }

        if( count($resource_types_seeded) < 1 ) {
            $this->call(ResourceTypeSeeder::class);
            DB::table('seeded')->insert(['is_seeded' => 'resource_types']);
        }

        if( count($user_types_seeded) < 1 ) {
            $this->call(UserTypeSeeder::class);
            DB::table('seeded')->insert(['is_seeded' => 'user_types']);
        }

        if( count($org_types_seeded) < 1 ) {
            $this->call(OrganisationTypeSeeder::class);
            DB::table('seeded')->insert(['is_seeded' => 'org_types']);
        }

        if( count($schools_seeded) < 1 ) {
            $this->call(UKSchoolSeeder::class);
            DB::table('seeded')->insert(['is_seeded' => 'schools']);
        }

    }
}
