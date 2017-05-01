<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();

             $table->integer('class_id')->unsigned()->nullable();
            $table->foreign('class_id')->references('id')->on('classes')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('staff_id')->unsigned()->nullable();
            $table->foreign('staff_id')->references('id')->on('staff')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
           
           $table->integer('organisation_id')->unsigned();
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
        Schema::drop('classes_staff');
    }
}
