<?php

use Illuminate\Database\Seeder;

class OrganisationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [];
        $types[] = ['label' => 'School', 'slug' => 'school'];
        $types[] = ['label' => 'University', 'slug' => 'university'];
        \DB::table('organisation_types')->insert($types);
    }
}
