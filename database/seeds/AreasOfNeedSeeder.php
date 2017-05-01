<?php

use Illuminate\Database\Seeder;
use App\Providers\ProvisionTracker\UniqueIdService;

class AreasOfNeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idService = new UniqueIdService();
        \DB::table('areas_of_need')->insert([
            'pt_id' => $idService->ptId(),
            'name' => 'No Parent',
            'slug' => str_slug('No Parent', '-'),
            'description' => ''
        ]);

    }
}
