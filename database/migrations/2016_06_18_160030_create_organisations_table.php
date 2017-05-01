<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisation_types', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('label');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            // We generate our own unique ids.
            // Useful when migrating across to new databses etc
            $table->uuid('pt_id')->nullable();
            $table->string('access')->nullable();
            $table->uuid('organisation_id');
            $table->text('name');
            $table->text('address');
            $table->string('slug');
            $table->integer('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('organisation_types');
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
        Schema::drop('organisations');
        Schema::drop('organisation_types');
    }
}
