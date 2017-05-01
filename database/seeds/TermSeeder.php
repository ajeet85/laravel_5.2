<?php

use Illuminate\Database\Seeder;
use App\Providers\ProvisionTracker\UniqueIdService;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idService = new UniqueIdService();
        \Excel::load('resources/assets/term-dates.xlsx', function($reader) use ($idService) {
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService) {
                    \DB::table('terms')->insert([
                        'pt_id' => $idService->ptId(),
                        'name' => $row->name,
                        'usage' => $row->usage,
                        'slug' => str_slug($row->name, '-'),
                        'start_date' => new \Carbon\Carbon($row->start),
                        'end_date' => new \Carbon\Carbon($row->end),
                    ]);
                });
            }
        });
    }
}
