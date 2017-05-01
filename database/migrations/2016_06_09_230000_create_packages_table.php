<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_groups', function (Blueprint $table) {
            $table->increments('id');
            // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('pt_id')->nullable();
            $table->text('label');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('pt_id')->nullable();
            $table->integer('package_group_id')->unsigned();
            $table->text('label');
            $table->text('static_id');
            $table->float('support_fee');
            $table->float('annual_fee');
            $table->float('mis_fee');
            $table->text('description');
            // Link the packages to a package group
            // so they can be organised into sets of packages
            $table->foreign('package_group_id')->references('id')->on('package_groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('package_cost_structure', function (Blueprint $table) {
            $table->text('label');
            $table->string('schedule');
            $table->string('table_column');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('package_cost_structure');
        Schema::drop('packages');
        Schema::drop('package_groups');
    }
}
