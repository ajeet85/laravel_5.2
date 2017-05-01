<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [];
        $types[] = ['label' => 'Super User', 'id' => 1];
        $types[] = ['label' => 'Standard User', 'id' => 2];
        \DB::table('user_types')->insert($types);
    }
}
