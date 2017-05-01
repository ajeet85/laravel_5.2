<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('pt_id')->nullable();
            $table->uuid('wonde_id')->nullable();
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('upi');        
            $table->string('initials');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_names');
            $table->string('legal_surname');
            $table->string('legal_forename');
            $table->string('avatar');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->text('description');
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
        Schema::drop('students');
    }
}
