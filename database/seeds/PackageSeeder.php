<?php

use Illuminate\Database\Seeder;
use App\Providers\ProvisionTracker\UniqueIdService;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idService = new UniqueIdService();

        // Add containing groups first
        \Excel::load('resources/assets/product-package-groups.xlsx', function($reader) use ($idService) {
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService) {
                    if( isset($row)){
                        \DB::table('package_groups')->insert([
                            'pt_id' => $idService->ptId(),
                            'label' => $row->label,
                            'description' => $row->description
                        ]);
                    }
                });
            }
        });

        // Add individual packages
        \Excel::load('resources/assets/product-packages.xlsx', function($reader) use ($idService) {
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService) {
                    if( isset($row->group)){
                        $package_group = \DB::table('package_groups')->where('label', '=', $row->group )->first();
                        if( $package_group != null) {
                            \DB::table('packages')->insert([
                                'pt_id' => $idService->ptId(),
                                'package_group_id' => $package_group->id,
                                'label' => $row->label,
                                'static_id' => $row->static_id,
                                'support_fee' => $row->support_fee,
                                'annual_fee' => $row->annual_fee,
                                'mis_fee' => $row->mis_fee,
                                'description' => $row->description
                            ]);
                        }
                    }
                });
            }
        });

        // Add cost structure
        \Excel::load('resources/assets/product-package-cost-structure.xlsx', function($reader) use ($idService) {
            foreach($reader->get() as $sheet)
            {
                $sheet->each(function( $row ) use ($idService) {
                    \DB::table('package_cost_structure')->insert([
                        'label' => $row->name,
                        'schedule' => $row->schedule,
                        'table_column' => $row->table_column,
                    ]);
                });
            }
        });
    }
}
