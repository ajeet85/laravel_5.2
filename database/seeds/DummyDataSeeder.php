<?php

use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superUsers     = [];
        $standardUsers  = [];
        $packageGroups  = [];
        $packages       = [];
        $accounts       = [];

        // Create users of both type
        $superUsers[] = factory(App\Models\SuperUser::class)->create();
        $superUsers[] = factory(App\Models\SuperUser::class)->create();
        $superUsers[] = factory(App\Models\SuperUser::class)->create();
        $superUsers[] = factory(App\Models\SuperUser::class)->create();
        $superUsers[] = factory(App\Models\SuperUser::class)->create();

        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();
        $standardUsers[] = factory(App\Models\StandardUser::class)->create();

        // Create packages and link them to a package group
        $packages['a'] = \DB::table('packages')->where('id', '=', 1 )->first();
        $packages['b'] = \DB::table('packages')->where('id', '=', 2 )->first();
        $packages['c'] = \DB::table('packages')->where('id', '=', 3 )->first();
        $packages['d'] = \DB::table('packages')->where('id', '=', 4 )->first();

        // Create our base accounts with assigned users
        $accounts['a'] = factory(App\Models\Account::class)
            ->create(['status' => 'active', 'package_id' => $packages['a']->id, 'manager_id' =>  $superUsers[0]->id]);

        $accounts['b'] = factory(App\Models\Account::class)
            ->create(['status' => 'active', 'package_id' => $packages['b']->id, 'manager_id' =>  $superUsers[1]->id]);

        $accounts['c'] = factory(App\Models\Account::class)
            ->create(['status' => 'active', 'package_id' => $packages['c']->id, 'manager_id' =>  $superUsers[2]->id]);

        $accounts['d'] = factory(App\Models\Account::class)
            ->create(['status' => 'active', 'package_id' => $packages['d']->id, 'manager_id' =>  $superUsers[3]->id]);

        $accounts['e'] = factory(App\Models\Account::class)
            ->create(['status' => 'active', 'package_id' => $packages['b']->id, 'manager_id' =>  $superUsers[4]->id]);

        // Create the replationship between the user and the account
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['a']->id, 'user_id'=>$superUsers[0]->id, 'type_id'=>1] );
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['b']->id, 'user_id'=>$superUsers[1]->id, 'type_id'=>1] );
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['c']->id, 'user_id'=>$superUsers[2]->id, 'type_id'=>1] );
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['d']->id, 'user_id'=>$superUsers[3]->id, 'type_id'=>1] );
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['e']->id, 'user_id'=>$superUsers[4]->id, 'type_id'=>1] );

        // Associate a user to muptiple accounts so we can test the login procedure
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['b']->id, 'user_id'=>$superUsers[0]->id, 'type_id'=>2] );
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['c']->id, 'user_id'=>$superUsers[0]->id, 'type_id'=>2] );
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['d']->id, 'user_id'=>$superUsers[0]->id, 'type_id'=>2] );
        factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['e']->id, 'user_id'=>$superUsers[0]->id, 'type_id'=>2] );

        // Associate all the standard users to the first account

        foreach ( $standardUsers as $user ) {
            factory(App\Models\UserAccountRelationship::class)->create( ['account_id'=>$accounts['a']->id,  'user_id'=>$user->id, 'type_id'=>2] );
        }

        // Create an organisation
        $org_name = "Whitemead Infant School";
        $org_slug = str_slug($org_name, '-');
        $org = factory(App\Models\Organisation::class)->create(['account_id'=>$accounts['a']->id, 'type_id'=>1, 'name'=>$org_name, 'slug'=>$org_slug]);

        // Add this organisation to the context
        $context = [];
        $context[] = ['label' => $org_name];
        \DB::table('permissable_context')->insert($context);

        // Add some students
        factory(App\Models\Student::class, 30)->create(['organisation_id' => $org->id]);

        // Staff members
        factory(App\Models\Staff::class, 15)->create(['organisation_id' => $org->id]);
    }
}
