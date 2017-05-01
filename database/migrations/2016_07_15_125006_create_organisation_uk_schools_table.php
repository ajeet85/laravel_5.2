<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisationUkSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisation_uk_schools', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('claimed')->nullable();
            $table->uuid('claimed_by')->nullable();
            $table->integer('links')->unsigned();
            $table->integer('urn')->unsigned();
            $table->integer('lac')->unsigned();
            $table->integer('en')->unsigned();
            $table->integer('dfe')->unsigned();
            $table->string('local_authority')->nullable();
            $table->string('name')->nullable();
            $table->string('street')->nullable();
            $table->string('postcode')->nullable();
            $table->string('school_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('organisation_uk_schools');
    }
}
