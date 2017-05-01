<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Actions
        $actions = [];
        $actions[] = ['label' => 'add'];
        $actions[] = ['label' => 'delete'];
        $actions[] = ['label' => 'edit'];
        $actions[] = ['label' => 'view'];
        $actions[] = ['label' => 'copy'];
        $actions[] = ['label' => 'send'];
        $actions[] = ['label' => 'share'];
        $actions[] = ['label' => 'export'];
        \DB::table('permissable_actions')->insert($actions);

        // Elements
        $elements = [];
        $elements[] = ['label' => 'pupils'];
        $elements[] = ['label' => 'teachers'];
        $elements[] = ['label' => 'classes'];
        $elements[] = ['label' => 'vulnerable groups'];
        $elements[] = ['label' => 'needs'];
        \DB::table('permissable_elements')->insert($elements);

        // Context
        // Contexts are added when an organisation is created
    }
}
