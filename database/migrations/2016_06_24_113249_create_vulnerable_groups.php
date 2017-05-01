<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVulnerableGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vulnerable_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned()->nullable();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
             // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('pt_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();;
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
        Schema::drop('vulnerable_groups');
    }
}
