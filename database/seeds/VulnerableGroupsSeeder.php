<?php

use Illuminate\Database\Seeder;
use App\Providers\ProvisionTracker\UniqueIdService;

class VulnerableGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idService = new UniqueIdService();
        \Excel::load('resources/assets/vulnerable-groups.xlsx', function($reader) use ($idService) {
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService) {
                    \DB::table('vulnerable_groups')->insert([
                        'pt_id' => $idService->ptId(),
                        'name' => $row->name,
                        'slug' => str_slug($row->name, '-'),
                        'description' => $row->description
                    ]);
                });
            }
        });
    }
}
