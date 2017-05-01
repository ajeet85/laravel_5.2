<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\SuperUser::class, function (Faker\Generator $faker) {
    $first_name = $faker->firstname();
    $last_name = $faker->lastName();
    $slug = str_slug("$first_name $last_name", '-');
    return [
        'pt_id'                  => $faker->randomNumber(7),
        'slug'                   => $slug,
        'first_name'             => $first_name,
        'last_name'              => $last_name,
        'email'                  => $faker->safeEmail,
        'password'               => bcrypt('tracker'),
        'remember_token'         => str_random(10)
    ];
});

$factory->define(App\Models\StandardUser::class, function (Faker\Generator $faker) {
    $first_name = $faker->firstname();
    $last_name = $faker->lastName();
    $slug = str_slug("$first_name $last_name", '-');
    return [
        'pt_id'                  => $faker->randomNumber(7),
        'slug'                   => $slug,
        'first_name'             => $first_name,
        'last_name'              => $last_name,
        'email'                  => $faker->safeEmail,
        'password'               => bcrypt('tracker'),
        'remember_token'         => str_random(10)
    ];
});

$factory->define(App\Models\UserType::class, function (Faker\Generator $faker) {
    return [
        'id'                     => $faker->randomNumber(7),
        'label'                  => $faker->words( 5, true )
    ];
});

$factory->define(App\Models\PackageGroup::class, function (Faker\Generator $faker) {
    return [
        'pt_id'                => $faker->randomNumber(7),
        'label'                => $faker->words( 5, true ),
        'description'          => $faker->sentence( 15, false )
    ];
});

$factory->define(App\Models\Package::class, function (Faker\Generator $faker) {
    return [
        'pt_id'                => $faker->randomNumber(7),
        'package_group_id'     => $faker->randomNumber(7),
        'label'                => $faker->words( 5, true ),
        'description'          => $faker->sentence( 15, false )
    ];
});

$factory->define(App\Models\Account::class, function (Faker\Generator $faker) {
    $name = $faker->word();
    return [
        'pt_id'                => $faker->randomNumber(7),
        'package_id'           => $faker->randomNumber(7),
        'status'               => $faker->words( 1, true ),
        'name'                 => $name,
        'slug'                 => str_slug($name, '-'),
        'renewal_date'         => $faker->date( $max = 'now', $timezone = date_default_timezone_get() )
    ];
});

$factory->define(App\Models\UserAccountRelationship::class, function (Faker\Generator $faker) {
    return [
        'account_id'        => $faker->randomNumber(7),
        'user_id'           => $faker->randomNumber(7),
        'type_id'           => $faker->randomNumber(7)
    ];
});

$factory->define(App\Models\Organisation::class, function (Faker\Generator $faker) {
    $name = $faker->word();
    return [
        'pt_id'                => $faker->randomNumber(7),
        'organisation_id'      => $faker->randomNumber(7),
        'name'                 => $name,
        'address'              => $faker->address(),
        'slug'                 => str_slug($name, '-'),
        'account_id'           => $faker->randomNumber(7),
        'type_id'              => $faker->randomNumber(7)
    ];
});

$factory->define(App\Models\OrganisationType::class, function (Faker\Generator $faker) {
    return [
        'label'                 => $faker->word()
    ];
});

$factory->define(App\Models\Student::class, function (Faker\Generator $faker) {
    $gender_choice = ['male', 'female'];
    $gender_key = array_rand($gender_choice);
    $gender = $gender_choice[$gender_key];
    $date = \Carbon\Carbon::now()->subYears(5);
    return [
        'pt_id'                => $faker->randomNumber(7),
        'student_id'           => $faker->randomNumber(7),
        'organisation_id'      => $faker->randomNumber(7),
        'first_name'           => $faker->firstname(),
        'last_name'            => $faker->lastName(),
        'avatar'               => $faker->image(),
        'gender'               => $gender,
        'date_of_birth'        => $date,
        'description'          => $faker->paragraph(5)
    ];
});

$factory->define(App\Models\Staff::class, function (Faker\Generator $faker) {
    $first_name = $faker->firstname();
    $last_name = $faker->lastName();
    $slug = str_slug("$first_name $last_name", '-');

    $provider_choice = ['yes', 'no'];
    $provider_key = array_rand($provider_choice);
    $provider = $provider_choice[$provider_key];

    return [
        'organisation_id'      => $faker->randomNumber(7),
        'pt_id'                => $faker->randomNumber(7),
        'first_name'           => $faker->firstname(),
        'last_name'            => $faker->lastName(),
        'slug'                 => str_slug($slug, '-'),
        'description'          => $faker->paragraph(5),
        'provider'             => $provider,
        'cost'                 => $faker->randomFloat(2)
    ];
});
