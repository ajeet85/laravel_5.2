<?php

use Illuminate\Database\Seeder;
use App\Providers\ProvisionTracker\UniqueIdService;
class ResourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idService = new UniqueIdService();
        $types = [];
        // ----------------------------------------
        // Digital resources
        $name = 'Digital Resource'; $slug = str_slug($name, '-');
        $types[] = ['pt_id' => $idService->ptId(), 'name' => $name, 'slug' => $slug ];
        // ----------------------------------------
        // Physical resources
        $name = 'Physical Resource'; $slug = str_slug($name, '-');
        $types[] = ['pt_id' => $idService->ptId(), 'name' => $name, 'slug' => $slug ];
        // ----------------------------------------
        // Locations
        $name = 'Location'; $slug = str_slug($name, '-');
        $types[] = ['pt_id' => $idService->ptId(), 'name' => $name, 'slug' => $slug ];
        // ----------------------------------------
        // External Providers
        $name = 'External Provider'; $slug = str_slug($name, '-');
        $types[] = ['pt_id' => $idService->ptId(), 'name' => $name, 'slug' => $slug ];


        \DB::table('resources_type')->insert($types);
    }
}
