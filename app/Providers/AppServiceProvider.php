<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'app.account-selection',
            'app.dashboard',
            'app.orgs.index',
            'app.orgs.new',
            'app.orgs.new-school',
            'app.orgs.new-university',
            'app.orgs.view',
            'app.term-dates.index',
            'app.term-dates.view',
            'app.term-dates.new',
            'app.term-dates.import',
            'app.students.index',
            'app.students.new',
            'app.students.view',
            'app.teachers.index',
            'app.teachers.view',
            'app.teachers.new',
            'app.classes.view',
            'app.classes.index',
            'app.classes.new',
            'app.assessment-types.index',
            'app.assessment-types.view',
            'app.assessment-types.view-locked',
            'app.assessment-types.copy',
            'app.assessment-types.import',
            'app.settings.index',
            'app.settings.profile',
            'app.settings.users',
            'app.settings.permissions',
            'app.settings.schedule',
            'app.settings.user-new',
            'app.settings.billing',
            'app.groups.index',
            'app.groups.view',
            'app.groups.new',
            'app.groups.import',
            'app.mis-sources.index',
            'app.mis-sources.groupcall',
            'app.mis-sources.assembly',
            'app.areaofneed.index',
            'app.areaofneed.new',
            'app.areaofneed.view',
            'app.areaofneed.import',
            'app.resources.index',
            'app.resources.index-digital',
            'app.resources.index-physical',
            'app.resources.index-location',
            'app.resources.index-ext-provider',
            'app.resources.new',
            'app.resources.new-digital',
            'app.resources.new-physical',
            'app.resources.new-location',
            'app.resources.new-ext-provider',
            'app.resources.view',
            'app.resources.view-digital',
            'app.resources.view-physical',
            'app.resources.view-location',
            'app.resources.view-ext-provider',
            'app.provisions.index',
            'app.provisions.new',
            'app.provisions.view',
            'app.time-slots.index',
            'app.time-slots.new',
            'app.time-slots.view',
            'app.profile.view',
            'app.profile.sections.reset-password',
            'app.profile.sections.email',
            'app.profile.sections.update-password',
            'app.profile.sections.update-email',
            'app.schedule.view',
            'app.billing.index',
            'app.billing.invoice'

        ],
            'App\Http\ViewComposers\BaseComposer'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
