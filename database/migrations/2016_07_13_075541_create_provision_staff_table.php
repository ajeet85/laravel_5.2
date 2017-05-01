<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provision_staff', function (Blueprint $table) {
            $table->integer('provision_id')->unsigned();
            $table->foreign('provision_id')->references('id')->on('provisions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('id')->on('staff')
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
        Schema::drop('provision_staff');
    }
}
