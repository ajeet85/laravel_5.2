<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
             // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('pt_id')->nullable();
            $table->uuid('wonde_id')->nullable();
            $table->string('class_name');
            $table->string('academic_year');
            $table->string('slug');
            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects')
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
        Schema::drop('classes');
    }
}
