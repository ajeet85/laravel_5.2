<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionDigitalResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provision_digital_resources', function (Blueprint $table) {

            $table->integer('provision_id')->unsigned();
            $table->foreign('provision_id')->references('id')->on('provisions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('digital_resource_id')->unsigned();
            $table->foreign('digital_resource_id')->references('id')->on('resources')
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
        Schema::drop('provision_digital_resources');
    }
}
