<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionVulnerableGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provision_vulnerable_groups', function (Blueprint $table) {
            
            $table->integer('provision_id')->unsigned();
            $table->foreign('provision_id')->references('id')->on('provisions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('vulnerable_groups')
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
        Schema::drop('provision_vulnerable_groups');
    }
}
