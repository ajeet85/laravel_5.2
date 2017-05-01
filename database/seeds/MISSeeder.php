<?php

use Illuminate\Database\Seeder;
use App\Providers\ProvisionTracker\UniqueIdService;

class MISSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add the provider sources first
        $idService = new UniqueIdService();

        \Excel::load('resources/assets/mis-providers.xlsx', function($reader) use ($idService) {
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService) {
                    \DB::table('mis_providers')->insert([
                        'pt_id' => $idService->ptId(),
                        'name' => $row->name,
                        'slug' => str_slug($row->name, '-'),
                        'description' => $row->description,
                        'template' => $row->template
                    ]);
                });
            }
        });


        // Add the services
        \Excel::load('resources/assets/mis-services.xlsx', function($reader) use ($idService) {
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService) {
                    $provider = \DB::table('mis_providers')->where('name', $row->provider )->first();
                    \DB::table('mis_services')->insert([
                        'pt_id' => $idService->ptId(),
                        'name' => $row->service,
                        'slug' => str_slug($row->service, '-'),
                        'description' => $row->description,
                        'notes' => $row->notes,
                        'weblink' => $row->weblink,
                        'provider_id' => $provider->id
                    ]);
                });
            }
        });
    }
}
