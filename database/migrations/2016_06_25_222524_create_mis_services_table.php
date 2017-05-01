<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMisServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mis_services', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->text('weblink')->nullable();
            $table->integer('provider_id')->unsigned();
            $table->foreign('provider_id')->references('id')->on('mis_providers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('mis_schools_services', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->uuid('school_id')->nullable();

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('mis_services')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('provider_id')->unsigned();
            $table->foreign('provider_id')->references('id')->on('mis_providers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('organisation_id')->unsigned()->nullable();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

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
        Schema::drop('mis_schools_services');
        Schema::drop('mis_services');
    }
}
