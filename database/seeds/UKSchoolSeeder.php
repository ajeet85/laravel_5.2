<?php

use Illuminate\Database\Seeder;

class UKSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit','256M');
        \Excel::load('resources/assets/uk-schools.xlsx', function($reader) {
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) {
                    \DB::table('organisation_uk_schools')->insert([
                        'claimed' => 'no',
                        'links' => 0,
                        'urn' => $row->urn,
                        'lac' => $row->lac,
                        'en' => $row->en,
                        'dfe' => $row->lac . $row->en,
                        'local_authority'=>$row->local_authority,
                        'name'=>$row->name,
                        'street'=>$row->street,
                        'postcode'=>$row->postcode,
                        'school_type'=>$row->school_type,
                    ]);
                });
            }
        });
    }
}
