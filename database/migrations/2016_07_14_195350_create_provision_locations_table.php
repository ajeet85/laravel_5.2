<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provision_locations', function (Blueprint $table) {

            $table->integer('provision_id')->unsigned();
            $table->foreign('provision_id')->references('id')->on('provisions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('resources')
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
        Schema::drop('provision_locations');
    }
}
