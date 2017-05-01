<?php

use Illuminate\Database\Seeder;
use App\Providers\ProvisionTracker\UniqueIdService;

class AssessmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $idService = new UniqueIdService();
        \Excel::load('resources/assets/assessment-types.xlsx', function($reader) use ($idService) {
            foreach($reader->get() as $sheet)
            {
                $sheetTitle = $sheet->getTitle();
                $id = \DB::table('assessment_types')->insertGetId([
                    'name' => $sheetTitle,
                    'pt_id' => $idService->ptId(),
                    'slug' => str_slug($sheetTitle, '-')
                ]);

                $sheet->each(function( $row ) use ($sheetTitle, $id, $idService) {
                    // \Log::info($row->public_grade);
                    \DB::table('assessment_type_grades')->insert([
                        'pt_id' => $idService->ptId(),
                        'name' => $sheetTitle,
                        'slug' => str_slug($sheetTitle, '-'),
                        'assessment_type' => $id,
                        'public_grade' => $row->public_grade,
                        'internal_grade' => $row->internal_grade,
                        'band' => $row->band,
                        'kpi' => $row->kpi
                    ]);
                });
            }
        });
    }
}
