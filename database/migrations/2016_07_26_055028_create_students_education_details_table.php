<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsEducationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_education_details', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('pt_id')->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('students')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
             $table->integer('admission_number')->nullable();
            $table->string('upn');
            $table->string('local_upn');
            $table->string('former_upn');
            $table->string('part_time');
            $table->dateTime('admission_date');
            $table->dateTime('leaving_date');
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
        Schema::drop('students_education_details');
    }
}
