<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatYearGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('year_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
             // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('pt_id')->nullable();
            $table->uuid('wonde_id')->nullable();
            $table->string('name');
            $table->string('code');
            $table->string('type');
            $table->string('description');
            $table->string('notes');
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
        //
        Schema::drop('year_groups');
    }
}
